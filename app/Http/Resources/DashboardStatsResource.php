<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardStatsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'monthly_revenue' => $this['monthly_revenue'],
            'pending_orders' => $this['pending_orders'],
            'sachets_produced_this_month' => $this['sachets_produced_this_month'],
            'plastic_avoided_kg' => $this['plastic_avoided_kg'],
            'cassava_stock_kg' => $this['cassava_stock_kg'],
            'cassava_alert' => $this['cassava_alert'],
            'weekly_sales' => $this['weekly_sales'],
            'jobs_created' => $this['jobs_created'],
            'partner_schools' => $this['partner_schools'],
            'clients_served' => $this['clients_served'],
        ];
    }
}
