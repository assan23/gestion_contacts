@extends('base')
@section('title', ($isUpdate ? 'Modifier' : 'Ajouter').' contact')

@php
    $route = $isUpdate ? route('contacts.update', $contact) : route('contacts.store');
@endphp

@section('content')
<div class="w-full md:w-2/3 mx-auto bg-white shadow-md rounded-md pt-6">
    <h1 class="text-3xl mb-6 px-6">@yield('title')</h1>
    <form id="contact-form" action="{{ $route }}" class="mx-auto" method="post">
        @csrf
        @if($isUpdate)
        @method('PUT')
        @endif
        <input type="hidden" name="confirmed" id="confirmed" value="false">
        <div class="px-6">
            <div class="flex items-center justify-between space-x-4 mb-4">
                <div class="w-1/2">
                    <label for="prenom" class="block mb-1">Prenom<span class="text-red-500">*</span></label>
                    <input type="text" id="prenom" name="prenom" placeholder="Prenom" class="bg-gray-40 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" value="{{ old('prenom', $contact->prenom ?? '') }}">

                    @if ($errors->has('prenom'))
                        @foreach ($errors->get('prenom') as $message)
                            <span class="text-red-500 text-sm">{{ $message }}</span><br>
                        @endforeach
                    @endif
                </div>
                <div class="w-1/2">
                    <label for="nom" class="block mb-1">Nom<span class="text-red-500">*</span></label>
                    <input type="text" id="nom" name="nom" placeholder="Nom" class="bg-gray-40 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" value="{{ old('nom', $contact->nom ?? '') }}">

                    @if ($errors->has('nom'))
                        @foreach ($errors->get('nom') as $message)
                            <span class="text-red-500 text-sm">{{ $message }}</span><br>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-1">E-mail<span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" placeholder="E-mail" class="bg-gray-40 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" value="{{ old('email', $contact->email ?? '') }}">
                @if ($errors->has('email'))
                        @foreach ($errors->get('email') as $message)
                            <span class="text-red-500 text-sm">{{ $message }}</span><br>
                        @endforeach
                @endif
            </div>
            <div class="mb-4">
                <label for="entreprise" class="block mb-1">Entreprise<span class="text-red-500">*</span></label>
                <input type="text" id="entreprise" name="entreprise" placeholder="Entreprise"
                        class="bg-gray-40 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5"
                        value="{{ old('entreprise', $organisation->entreprise ?? '') }}">

                @if ($errors->has('entreprise'))
                        @foreach ($errors->get('entreprise') as $message)
                            <span class="text-red-500 text-sm">{{ $message }}</span><br>
                        @endforeach
                @endif
            </div>
            <div class="mb-4">
                <label for="adresse" class="block mb-1">Adresse</label>
                <textarea id="adresse" name="adresse" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-40 rounded-lg border border-gray-300 focus:border-blue-500" placeholder="Adresse">{{ old('adresse', $organisation->adresse ?? '') }}</textarea>
            </div>
            <div class="flex items-center justify-between space-x-4 mb-4">
                <div class="w-1/4">
                    <label for="code_postal" class="block mb-1">Code Postale</label>
                    <input type="text" id="code_postal" name="code_postal" placeholder="Code Postale"
                        class="bg-gray-40 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5"
                        value="{{ old('code_postal', $organisation->code_postal ?? '') }}">

                    @if ($errors->has('code_postal'))
                        @foreach ($errors->get('code_postal') as $message)
                            <span class="text-red-500 text-sm">{{ $message }}</span><br>
                        @endforeach
                    @endif
                </div>
                <div class="w-3/4">
                    <label for="ville" class="block mb-1">Ville</label>
                    <input type="text" id="ville" name="ville" placeholder="Ville"
                            class="bg-gray-40 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5"
                            value="{{ old('ville', $organisation->ville ?? '') }}">
                </div>
            </div>
            <div class="mb-4">
                <label for="statut" class="block mb-1">Statut</label>
                <select id="statut" name="statut" class="bg-gray-40 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5">
                    <option value="">Choisir un statut</option>
                    <option value="CLIENT" @selected(old('statut', $organisation->statut ?? '') === 'CLIENT')>Client</option>
                    <option value="LEAD" @selected(old('statut', $organisation->statut ?? '') === 'LEAD')>Lead</option>
                    <option value="PROSPECT" @selected(old('statut', $organisation->statut ?? '') === 'PROSPECT')>Prospect</option>
                </select>
            </div>
        </div>

        <!-- Modal for Duplicate Contact -->
        <div x-data="{ showDuplicateContactModal: {{ session('duplicateContact') ? 'true' : 'false' }} }">
            <template x-if="showDuplicateContactModal">
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4 mb-4">
                            <h2 class="text-xl font-semibold mb-4">Doublon</h2>
                            <p>Un contact exist deja avec le meme nom et le meme prenom.</p>
                            <p>Etes vous sur de vouloire ajouter ce contact ?</p>
                        </div>
                        <div class="bg-gray-100 p-2 flex justify-end">
                            <button type="button" @click="showDuplicateContactModal = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuler</button>
                            <button type="button" @click="document.getElementById('confirmed').value = 'true'; document.getElementById('contact-form').submit();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-3 rounded">Confirmer</button>
                        </div>
                    </div>
                </div>
            </template>

        </div>

        <!-- Modal for Duplicate Organisation -->
        <div x-data="{ showDuplicateCompanyModal: {{ session('duplicateCompany') ? 'true' : 'false' }} }">
            <template x-if="showDuplicateCompanyModal">
                <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                        <div class="bg-white border border-gray-300 rounded-lg shadow-lg overflow-hidden">
                            <div class="p-4 mb-4">
                                <h2 class="text-xl font-semibold mb-4">Doublon</h2>
                                <p>Un contact exist deja avec le meme entreprise.</p>
                                <p>Etes vous sur de vouloire ajouter ce contact ?</p>
                            </div>
                            <div class="bg-gray-100 p-2 flex justify-end">
                                <button type="button" @click="showDuplicateCompanyModal = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Annuler</button>
                                <button type="button" @click="document.getElementById('confirmed').value = 'true'; document.getElementById('contact-form').submit();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-3 rounded">Confirmer</button>
                            </div>
                        </div>
                </div>
            </template>

        </div>

        <div class="flex justify-end p-4 bg-gray-100">
            <button type="button" onclick="window.history.back()" class="bg-gray-100 border border-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mx-2">Annuler</button>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">{{ $isUpdate ? 'Modifier' : 'Ajouter' }}</button>
        </div>
    </form>
</div>
@endsection
