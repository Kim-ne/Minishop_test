<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\CustomerServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerServiceInterface $customerService,
    ) {}
    /**
     * Summary of index
     * @return view
     */
    public function index(): View
    {
        $customer = $this->customerService->index();

        return view('Backend.auth.customerList', [
            'customers' => $customer
        ]);
    }

    /**
     * Summary of show
     * @param int $id
     * @return view
     */
    public function show(int $id): View
    {
        $customer = $this->customerService->show($id);

        return view('Backend.auth.customer-detail', [
            'customer' => $customer
        ]);
    }

    /**
     * Summary of toggleStatus
     * @param int $id
     * @return RedirectResponse
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        try
        {
            $this->customerService->toggleStatus($id);

            return redirect()->route('customer.index')->with('success', 'Customer status updated successfully');

        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        };
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try
        {
            $this->customerService->destroy($id);

            return redirect()->route('customer.index')->with('success', 'Customer deleted successfully');

        } catch (\Exception $e)
        {
            return redirect()->back()->with('error', $e->getMessage());
        };
    }
}
