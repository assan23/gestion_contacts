<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\OrganisationRequest;
use App\Models\Organisation;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
    {
        $searchTerm = $request->input('term');
        $sortBy = $request->query('sortBy', 'nom');
        $sortDirection = $request->query('sortDirection', 'asc');

        $contacts = Contact::query()
            ->join('organisations', 'contacts.organisation_id', '=', 'organisations.id')
            ->select('contacts.*', 'organisations.entreprise as entreprise_nom', 'organisations.statut as entreprise_statut')
            ->when($searchTerm, function ($query, $searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('contacts.nom', 'like', '%' . $searchTerm . '%')
                          ->orWhere('contacts.prenom', 'like', '%' . $searchTerm . '%')
                          ->orWhere('organisations.entreprise', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderBy($this->getSortColumn($sortBy), $sortDirection)
            ->paginate(6);

        return view('contact.index', compact('contacts', 'sortBy', 'sortDirection', 'searchTerm'));
    }

    private function getSortColumn($sortBy)
    {
        $columns = [
            'nom' => 'contacts.nom',
            'entreprise' => 'organisations.entreprise',
            'entreprise.statut' => 'organisations.statut',
        ];

        return $columns[$sortBy] ?? 'contacts.nom';
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contact = new Contact();
        $organisation = null;
        $duplicateContact = false;
        $duplicateCompany = false;
        $isUpdate = false;

        return view('contact.form', compact('contact', 'organisation', 'duplicateContact', 'duplicateCompany', 'isUpdate'));
    }

/**
 * Store a newly created resource in storage.
 */
public function store(ContactRequest $request)
    {
        $validatedData = $request->validated();

        $isConfirmed = $request->input('confirmed') === 'true';

        // Check for duplicate contact
        if (!$isConfirmed) {
            $duplicateContact = Contact::where('prenom', $validatedData['prenom'])
                                    ->where('nom', $validatedData['nom'])
                                    ->exists();

            // Check for duplicate company
            $duplicateCompany = Organisation::where('entreprise', $validatedData['entreprise'])
                                            ->exists();

            if ($duplicateContact || $duplicateCompany) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        'duplicateContact' => $duplicateContact,
                        'duplicateCompany' => $duplicateCompany,
                    ]);
            }
        }

        // Create the Organisation
        $organisation = Organisation::create([
            'entreprise' => $validatedData['entreprise'],
            'adresse' => $request->adresse,
            'code_postal' => $validatedData['code_postal'],
            'ville' => $request->ville,
            'statut' => $request->statut,
        ]);

        // Create the Contact and associate it with the Organisation
        Contact::create([
            'prenom' => ucwords(strtolower($validatedData['prenom'])),
            'nom' => ucwords(strtolower($validatedData['nom'])),
            'email' => strtolower($validatedData['email']),
            'organisation_id' => $organisation->id,
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully');
    }





    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $organisation = $contact->organisation;
        return view('contact.alert', compact('contact', 'organisation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $organisation = $contact->organisation;
        $isUpdate = true;
        return view('contact.form', compact('contact', 'organisation', 'isUpdate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $validatedData = $request->validated();
        $contact->fill($validatedData)->save();

        $contact->organisation->fill([
            'entreprise' => $validatedData['entreprise'],
            'adresse' => $request->adresse, // Optional fields
            'code_postal' => $validatedData['code_postal'], // Optional fields
            'ville' => $request->ville, // Optional fields
            'statut' => $request->statut, // Optional fields
        ])->save();

        return to_route('contacts.index')->with('success', 'Contact updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        $contact->organisation()->delete();

        return to_route('contacts.index')->with('success', 'Contact deleted successfully');
    }


}
