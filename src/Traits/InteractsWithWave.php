<?php

namespace Wave\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Wave\Models\Plan;

trait InteractsWithWave
{
    public function onTrial()
    {
        if (is_null($this->trial_ends_at)) {
            return false;
        }
        if ($this->subscriber()) {
            return false;
        }

        return true;
    }

    public function subscriptions()
    {
        return $this->hasMany(config('wave.models.subscriptions'), 'billable_id')->where('billable_type', 'user');
    }

    public function subscriber()
    {
        return $this->subscriptions()->where('status', 'active')->exists();
    }

    public function subscribedToPlan($planSlug)
    {
        $plan = config('wave.models.plans')::where('name', $planSlug)->first();
        if (! $plan) {
            return false;
        }

        return $this->subscriptions()->where('plan_id', $plan->id)->where('status', 'active')->exists();
    }

    public function plan()
    {
        $latest_subscription = $this->latestSubscription();

        return Plan::find($latest_subscription->plan_id);
    }

    public function planInterval()
    {
        $latest_subscription = $this->latestSubscription();

        return ($latest_subscription->cycle == 'month') ? 'Monthly' : 'Yearly';
    }

    public function latestSubscription()
    {
        return $this->subscriptions()->where('status', 'active')->orderBy('created_at', 'desc')->first();
    }

    public function subscription()
    {
        return $this->hasOne(config('wave.models.subscriptions'), 'billable_id')->where('status', 'active')->orderBy('created_at', 'desc');
    }

    public function switchPlans(Plan $plan)
    {
        $this->syncRoles([]);
        $this->assignRole($plan->role->name);
    }

    public function invoices()
    {
        $user_invoices = [];

        if (is_null($this->subscription)) {
            return null;
        }

        if (config('wave.billing_provider') == 'stripe') {
            $stripe = new \Stripe\StripeClient(config('wave.stripe.secret_key'));
            $subscriptions = $this->subscriptions()->get();
            foreach ($subscriptions as $subscription) {
                $invoices = $stripe->invoices->all(['customer' => $subscription->vendor_customer_id, 'limit' => 100]);

                foreach ($invoices as $invoice) {
                    array_push($user_invoices, (object) [
                        'id' => $invoice->id,
                        'created' => \Carbon\Carbon::parse($invoice->created)->isoFormat('MMMM Do YYYY, h:mm:ss a'),
                        'total' => number_format(($invoice->total / 100), 2, '.', ' '),
                        'download' => $invoice->invoice_pdf,
                    ]);
                }
            }
        } else {
            $paddle_url = (config('wave.paddle.env') == 'sandbox') ? 'https://sandbox-api.paddle.com' : 'https://api.paddle.com';
            $response = Http::withToken(config('wave.paddle.api_key'))->get($paddle_url . '/transactions', [
                'subscription_id' => $this->subscription->vendor_subscription_id,
            ]);
            $responseJson = json_decode($response->body());
            foreach ($responseJson->data as $invoice) {
                array_push($user_invoices, (object) [
                    'id' => $invoice->id,
                    'created' => \Carbon\Carbon::parse($invoice->created_at)->isoFormat('MMMM Do YYYY, h:mm:ss a'),
                    'total' => number_format(($invoice->details->totals->subtotal / 100), 2, '.', ' '),
                    'download' => '/settings/invoices/' . $invoice->id,
                ]);
            }
        }

        return $user_invoices;
    }

    public function isAdmin()
    {
        return false;
    }

    public function isImpersonated()
    {
        return false;
    }

    public function hasChangelogNotifications()
    {
        return false;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function profile($key)
    {
        $keyValue = $this->profileKeyValue($key);

        return isset($keyValue->value) ? $keyValue->value : '';
    }

    /**
     * @return bool
     */
    public function canImpersonate()
    {
        // If user is admin they can impersonate
        return $this->hasRole('admin');
    }

    /**
     * @return bool
     */
    public function canBeImpersonated()
    {
        // Any user that is not an admin can be impersonated
        return ! $this->hasRole('admin');
    }

    public function link()
    {
        return url('/profile/' . $this->username);
    }

    public function changelogs()
    {
        return $this->belongsToMany(config('wave.models.changelogs'));
    }

    public function createApiKey($name)
    {
        return config('wave.models.api_keys')::create(['user_id' => $this->id, 'name' => $name, 'key' => Str::random(60)]);
    }

    public function apiKeys()
    {
        return $this->hasMany(config('wave.models.api_keys'), 'user_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function avatar()
    {
        return Storage::url($this->avatar);
    }
}
