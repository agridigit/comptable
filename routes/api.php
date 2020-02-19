<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Statuts
    Route::post('statuts/media', 'StatutApiController@storeMedia')->name('statuts.storeMedia');
    Route::apiResource('statuts', 'StatutApiController');

    // Registre De Commerces
    Route::post('registre-de-commerces/media', 'RegistreDeCommerceApiController@storeMedia')->name('registre-de-commerces.storeMedia');
    Route::apiResource('registre-de-commerces', 'RegistreDeCommerceApiController');

    // Taxe Professionnelles
    Route::post('taxe-professionnelles/media', 'TaxeProfessionnelleApiController@storeMedia')->name('taxe-professionnelles.storeMedia');
    Route::apiResource('taxe-professionnelles', 'TaxeProfessionnelleApiController');

    // Certificat Negatifs
    Route::post('certificat-negatifs/media', 'CertificatNegatifApiController@storeMedia')->name('certificat-negatifs.storeMedia');
    Route::apiResource('certificat-negatifs', 'CertificatNegatifApiController');

    // Identifiant Fiscals
    Route::post('identifiant-fiscals/media', 'IdentifiantFiscalApiController@storeMedia')->name('identifiant-fiscals.storeMedia');
    Route::apiResource('identifiant-fiscals', 'IdentifiantFiscalApiController');

    // Cingerants
    Route::post('cingerants/media', 'CingerantApiController@storeMedia')->name('cingerants.storeMedia');
    Route::apiResource('cingerants', 'CingerantApiController');

    // Pv Pouvoirs
    Route::post('pv-pouvoirs/media', 'PvPouvoirApiController@storeMedia')->name('pv-pouvoirs.storeMedia');
    Route::apiResource('pv-pouvoirs', 'PvPouvoirApiController');

    // Autorisation Dactivites
    Route::post('autorisation-dactivites/media', 'AutorisationDactiviteApiController@storeMedia')->name('autorisation-dactivites.storeMedia');
    Route::apiResource('autorisation-dactivites', 'AutorisationDactiviteApiController');

    // Dossier Assurances
    Route::post('dossier-assurances/media', 'DossierAssuranceApiController@storeMedia')->name('dossier-assurances.storeMedia');
    Route::apiResource('dossier-assurances', 'DossierAssuranceApiController');

    // Autre Documents
    Route::post('autre-documents/media', 'AutreDocumentsApiController@storeMedia')->name('autre-documents.storeMedia');
    Route::apiResource('autre-documents', 'AutreDocumentsApiController');

    // Declaration Tvas
    Route::post('declaration-tvas/media', 'DeclarationTvaApiController@storeMedia')->name('declaration-tvas.storeMedia');
    Route::apiResource('declaration-tvas', 'DeclarationTvaApiController');

    // Bilans
    Route::post('bilans/media', 'BilanApiController@storeMedia')->name('bilans.storeMedia');
    Route::apiResource('bilans', 'BilanApiController');

    // Ir Sur Salaires
    Route::post('ir-sur-salaires/media', 'IrSurSalaireApiController@storeMedia')->name('ir-sur-salaires.storeMedia');
    Route::apiResource('ir-sur-salaires', 'IrSurSalaireApiController');

    // Pv Tribunals
    Route::post('pv-tribunals/media', 'PvTribunalApiController@storeMedia')->name('pv-tribunals.storeMedia');
    Route::apiResource('pv-tribunals', 'PvTribunalApiController');

    // Rapprochement Bancaires
    Route::post('rapprochement-bancaires/media', 'RapprochementBancaireApiController@storeMedia')->name('rapprochement-bancaires.storeMedia');
    Route::apiResource('rapprochement-bancaires', 'RapprochementBancaireApiController');

    // Balances
    Route::post('balances/media', 'BalanceApiController@storeMedia')->name('balances.storeMedia');
    Route::apiResource('balances', 'BalanceApiController');

    // Etat Des Horaires
    Route::post('etat-des-horaires/media', 'EtatDesHorairesApiController@storeMedia')->name('etat-des-horaires.storeMedia');
    Route::apiResource('etat-des-horaires', 'EtatDesHorairesApiController');

    // Grand Livres
    Route::post('grand-livres/media', 'GrandLivreApiController@storeMedia')->name('grand-livres.storeMedia');
    Route::apiResource('grand-livres', 'GrandLivreApiController');

    // Liste Des Moyens
    Route::post('liste-des-moyens/media', 'ListeDesMoyensApiController@storeMedia')->name('liste-des-moyens.storeMedia');
    Route::apiResource('liste-des-moyens', 'ListeDesMoyensApiController');

    // Autres
    Route::post('autres/media', 'AutresApiController@storeMedia')->name('autres.storeMedia');
    Route::apiResource('autres', 'AutresApiController');
});
