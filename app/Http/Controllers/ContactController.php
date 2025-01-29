<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::all();
        foreach ($contacts as $contact) {
            $contact->status_delete = $contact->type == "social-media" ? true : false;
        }
        $page_name = 'Contact';
        $breadcrumbs = [
            [
                'value' => 'Contact',
                'url' => '',
            ],
        ];
        return view('dashboard.views.landing-page-setting.contact.index-contact', compact('contacts', 'page_name', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'icon' => 'required',
                'link' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Please fill all required fields');
            }

            Contact::create([
                'title' => $request->title,
                'value' => $request->value,
                'icon' => $request->icon,
                'type' => "social-media",
                'link' => $request->link,
                'landing_page_id' => 1,
            ]);

            return redirect()->back()->with('success', 'Contact added successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $contact = Contact::find($id);
            if (!$contact) {
                return redirect()->back()->with('error', 'Contact not found');
            }

            $page_name = 'Edit Contact';
            $breadcrumbs = [
                [
                    'value' => 'Contact',
                    'url' => 'landing-page-settings.contact.index',
                ],
                [
                    'value' => 'Edit Contact',
                    'url' => '',
                ],
            ];
            return view('dashboard.views.landing-page-setting.contact.edit-contact', compact('contact', 'page_name', 'breadcrumbs'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'value' => 'required',
                'icon' => 'required',
                'link' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Please fill all required fields');
            }
            $id = decrypt($id);
            $contact = Contact::find($id);
            if (!$contact) {
                return redirect()->back()->with('error', 'Contact not found');
            }

            $update = [
                'title' => $request->title,
                'value' => $request->value,
                'icon' => $request->icon,
            ];

            if ($request->link) {
                $update['link'] = $request->link;
            }

            Contact::where('id', $id)->update($update);

            return redirect()->route('landing-page-settings.contact.index')->with('success', 'Contact updated successfully');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id = decrypt($id);
            $contact = Contact::find($id);
            if (!$contact) {
                return redirect()->back()->with('error', 'Contact not found');
            }
            if($contact->type != "social-media") {
                return redirect()->back()->with('error', 'Contact cannot be deleted');
            }
            Contact::where('id', $id)->delete();
            return redirect()->back()->with('success', 'Contact deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
