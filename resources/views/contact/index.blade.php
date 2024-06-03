@extends('base')
@section('title', 'Contacts')

@section('content')
    <h1 class="text-3xl">Liste des contacts</h1>
    <div class="flex items-center justify-between my-5">
        <div class="w-2/4">
            <form method="GET" action="{{ route('contacts.index') }}" id="searchForm">
                <input
                    type="text"
                    name="term"
                    value="{{ request('term') }}"
                    placeholder="Recherche..."
                    class="w-full px-4 py-2 border rounded"
                    id="searchInput"
                />
            </form>
        </div>
        <div>
            <a href="{{ route('contacts.create') }}" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Ajouter
            </a>

        </div>
    </div>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-4">
        <table class="w-full text-sm text-left rtl:text-right">
            <thead class="text-gray-500 uppercase bg-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('contacts.index', ['sortBy' => 'nom', 'sortDirection' => $sortDirection === 'asc' && $sortBy === 'nom' ? 'desc' : 'asc']) }}">
                            NOM DU CONTACT
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('contacts.index', ['sortBy' => 'entreprise', 'sortDirection' => $sortDirection === 'asc' && $sortBy === 'entreprise' ? 'desc' : 'asc']) }}">
                            SOCIETE
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('contacts.index', ['sortBy' => 'entreprise.statut', 'sortDirection' => $sortDirection === 'asc' && $sortBy === 'entreprise.statut' ? 'desc' : 'asc']) }}">
                            STATUT
                        </a>
                    </th>
                    <th scope="col" class="px-6 py-3"></th>
                </tr>
            </thead>

            <tbody>
                @forelse ($contacts as $contact)
                    <tr class="bg-white border-b  hover:bg-gray-50">
                        <td class="px-6 py-4">
                            {{$contact->nom.' '.$contact->prenom}}
                        </td>
                        <td class="px-6 py-4 font-bold">
                            {{$contact->organisation->entreprise}}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @switch($contact->organisation->statut)
                                    @case('LEAD')
                                        bg-blue-200
                                        @break
                                    @case('CLIENT')
                                        bg-green-200
                                        @break
                                    @case('PROSPECT')
                                        bg-orange-200
                                        @break
                                    @default
                                        bg-gray-400 text-white
                                @endswitch
                            ">
                                {{ $contact->organisation->statut }}
                            </span>
                        </td>
                        <td class="px-8 py-4 flex justify-end ">
                            <div x-data="{ showAlert: false }">
                                <!-- The icon that will trigger the alert -->
                                <svg @click="showAlert = true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 cursor-pointer">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                                </svg>

                                <!-- The alert with the form -->
                                <div x-show="showAlert" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white rounded shadow-lg w-1/2 my-4 space-y-4 max-h-[90vh] overflow-y-auto">
                                        <h2 class="text-xl font-semibold m-4">Détail du contact</h2>
                                        <form class="mx-auto">
                                            <div class="px-6">
                                                <div class="flex items-center justify-between space-x-4 mb-4">
                                                    <div class="w-1/2">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900">Prenom</label>
                                                        <input type="text" name="prenom"
                                                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs"
                                                            value="{{$contact->prenom}}" disabled>
                                                    </div>
                                                    <div class="w-1/2">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
                                                        <input type="text" name="nom"
                                                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs"
                                                            value="{{$contact->nom}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900">E-mail</label>
                                                    <input type="email" name="email"
                                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs"
                                                        value="{{$contact->email}}" disabled>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900">Entreprise</label>
                                                    <input type="text" name="entreprise"
                                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs"
                                                        value="{{$contact->organisation->entreprise}}" disabled>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900">Adresse</label>
                                                    <textarea name="adresse" rows="1"
                                                        class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs" disabled>
                                                        {{$contact->organisation->adresse}}
                                                    </textarea>
                                                </div>
                                                <div class="flex items-center justify-between space-x-4 mb-4">
                                                    <div class="w-1/4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900">Code Postale</label>
                                                        <input type="text" name="code_postal"
                                                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs"
                                                            value="{{$contact->organisation->code_postal}}" disabled>
                                                    </div>
                                                    <div class="w-3/4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900">Ville</label>
                                                        <input type="text" name="ville"
                                                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs"
                                                            value="{{$contact->organisation->ville}}" disabled>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900">Statut</label>
                                                    <select name="statut" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs" disabled>
                                                        <option value="CLIENT" @selected($contact->organisation->statut === 'CLIENT')>Client</option>
                                                        <option value="LEAD" @selected($contact->organisation->statut === 'LEAD')>Lead</option>
                                                        <option value="PROSPECT" @selected($contact->organisation->statut === 'PROSPECT')>Prospect</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="flex justify-end p-3 bg-gray-100">
                                                <button type="reset" class="bg-gray-100 border border-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mx-2">Annuler</button>
                                                <button type="button" @click="showAlert = false" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Valider</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>

                            <a href="{{ route('contacts.edit', $contact) }}" class="text-gray-500 hover:text-gray-700 focus:outline-none mx-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                    <path fill-rule="evenodd" d="M12.1 3.667a3.502 3.502 0 1 1 6.782 1.738 3.487 3.487 0 0 1-.907 1.57 3.495 3.495 0 0 1-1.617.919L16 7.99V10a.75.75 0 0 1-.22.53l-.25.25a.75.75 0 0 1-1.06 0l-.845-.844L7.22 16.34A2.25 2.25 0 0 1 5.629 17H5.12a.75.75 0 0 0-.53.22l-1.56 1.56a.75.75 0 0 1-1.061 0l-.75-.75a.75.75 0 0 1 0-1.06l1.56-1.561a.75.75 0 0 0 .22-.53v-.508c0-.596.237-1.169.659-1.59l6.405-6.406-.844-.845a.75.75 0 0 1 0-1.06l.25-.25A.75.75 0 0 1 10 4h2.01l.09-.333ZM4.72 13.84l6.405-6.405 1.44 1.439-6.406 6.405a.75.75 0 0 1-.53.22H5.12c-.258 0-.511.044-.75.129a2.25 2.25 0 0 0 .129-.75v-.508a.75.75 0 0 1 .22-.53Z" clip-rule="evenodd" />
                                </svg>
                            </a>

                            <div x-data="{ open: false }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-red-600 cursor-pointer hover:text-red-800"
                                     @click="open = true"
                                     >
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                </svg>

                                <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                                    <div class="bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden">
                                        <div class="p-4 mb-4">
                                            <h2 class="text-xl font-semibold mb-4">Confirmer la suppression</h2>
                                            <p>Êtes-vous sûr de vouloir supprimer ce contact ?</p>
                                        </div>
                                        <div class="bg-gray-100 p-2 flex justify-end">
                                            <button type="button" @click="open = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuler</button>
                                            <form id="delete-contact-form-{{ $contact->id }}" action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">Confirmer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <h6 class="text-lg font-semibold text-gray-700">Aucune Contact!</h6>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>
        {{ $contacts->appends(request()->query())->links() }}
    </div>

@endsection
