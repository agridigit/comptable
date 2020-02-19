<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Statuts
    Route::delete('statuts/destroy', 'StatutController@massDestroy')->name('statuts.massDestroy');
    Route::post('statuts/media', 'StatutController@storeMedia')->name('statuts.storeMedia');
    Route::post('statuts/ckmedia', 'StatutController@storeCKEditorImages')->name('statuts.storeCKEditorImages');
    Route::post('statuts/parse-csv-import', 'StatutController@parseCsvImport')->name('statuts.parseCsvImport');
    Route::post('statuts/process-csv-import', 'StatutController@processCsvImport')->name('statuts.processCsvImport');
    Route::resource('statuts', 'StatutController');

    // Registre De Commerces
    Route::delete('registre-de-commerces/destroy', 'RegistreDeCommerceController@massDestroy')->name('registre-de-commerces.massDestroy');
    Route::post('registre-de-commerces/media', 'RegistreDeCommerceController@storeMedia')->name('registre-de-commerces.storeMedia');
    Route::post('registre-de-commerces/ckmedia', 'RegistreDeCommerceController@storeCKEditorImages')->name('registre-de-commerces.storeCKEditorImages');
    Route::post('registre-de-commerces/parse-csv-import', 'RegistreDeCommerceController@parseCsvImport')->name('registre-de-commerces.parseCsvImport');
    Route::post('registre-de-commerces/process-csv-import', 'RegistreDeCommerceController@processCsvImport')->name('registre-de-commerces.processCsvImport');
    Route::resource('registre-de-commerces', 'RegistreDeCommerceController');

    // Taxe Professionnelles
    Route::delete('taxe-professionnelles/destroy', 'TaxeProfessionnelleController@massDestroy')->name('taxe-professionnelles.massDestroy');
    Route::post('taxe-professionnelles/media', 'TaxeProfessionnelleController@storeMedia')->name('taxe-professionnelles.storeMedia');
    Route::post('taxe-professionnelles/ckmedia', 'TaxeProfessionnelleController@storeCKEditorImages')->name('taxe-professionnelles.storeCKEditorImages');
    Route::post('taxe-professionnelles/parse-csv-import', 'TaxeProfessionnelleController@parseCsvImport')->name('taxe-professionnelles.parseCsvImport');
    Route::post('taxe-professionnelles/process-csv-import', 'TaxeProfessionnelleController@processCsvImport')->name('taxe-professionnelles.processCsvImport');
    Route::resource('taxe-professionnelles', 'TaxeProfessionnelleController');

    // Certificat Negatifs
    Route::delete('certificat-negatifs/destroy', 'CertificatNegatifController@massDestroy')->name('certificat-negatifs.massDestroy');
    Route::post('certificat-negatifs/media', 'CertificatNegatifController@storeMedia')->name('certificat-negatifs.storeMedia');
    Route::post('certificat-negatifs/ckmedia', 'CertificatNegatifController@storeCKEditorImages')->name('certificat-negatifs.storeCKEditorImages');
    Route::post('certificat-negatifs/parse-csv-import', 'CertificatNegatifController@parseCsvImport')->name('certificat-negatifs.parseCsvImport');
    Route::post('certificat-negatifs/process-csv-import', 'CertificatNegatifController@processCsvImport')->name('certificat-negatifs.processCsvImport');
    Route::resource('certificat-negatifs', 'CertificatNegatifController');

    // Identifiant Fiscals
    Route::delete('identifiant-fiscals/destroy', 'IdentifiantFiscalController@massDestroy')->name('identifiant-fiscals.massDestroy');
    Route::post('identifiant-fiscals/media', 'IdentifiantFiscalController@storeMedia')->name('identifiant-fiscals.storeMedia');
    Route::post('identifiant-fiscals/ckmedia', 'IdentifiantFiscalController@storeCKEditorImages')->name('identifiant-fiscals.storeCKEditorImages');
    Route::post('identifiant-fiscals/parse-csv-import', 'IdentifiantFiscalController@parseCsvImport')->name('identifiant-fiscals.parseCsvImport');
    Route::post('identifiant-fiscals/process-csv-import', 'IdentifiantFiscalController@processCsvImport')->name('identifiant-fiscals.processCsvImport');
    Route::resource('identifiant-fiscals', 'IdentifiantFiscalController');

    // Cingerants
    Route::delete('cingerants/destroy', 'CingerantController@massDestroy')->name('cingerants.massDestroy');
    Route::post('cingerants/media', 'CingerantController@storeMedia')->name('cingerants.storeMedia');
    Route::post('cingerants/ckmedia', 'CingerantController@storeCKEditorImages')->name('cingerants.storeCKEditorImages');
    Route::post('cingerants/parse-csv-import', 'CingerantController@parseCsvImport')->name('cingerants.parseCsvImport');
    Route::post('cingerants/process-csv-import', 'CingerantController@processCsvImport')->name('cingerants.processCsvImport');
    Route::resource('cingerants', 'CingerantController');

    // Pv Pouvoirs
    Route::delete('pv-pouvoirs/destroy', 'PvPouvoirController@massDestroy')->name('pv-pouvoirs.massDestroy');
    Route::post('pv-pouvoirs/media', 'PvPouvoirController@storeMedia')->name('pv-pouvoirs.storeMedia');
    Route::post('pv-pouvoirs/ckmedia', 'PvPouvoirController@storeCKEditorImages')->name('pv-pouvoirs.storeCKEditorImages');
    Route::post('pv-pouvoirs/parse-csv-import', 'PvPouvoirController@parseCsvImport')->name('pv-pouvoirs.parseCsvImport');
    Route::post('pv-pouvoirs/process-csv-import', 'PvPouvoirController@processCsvImport')->name('pv-pouvoirs.processCsvImport');
    Route::resource('pv-pouvoirs', 'PvPouvoirController');

    // Autorisation Dactivites
    Route::delete('autorisation-dactivites/destroy', 'AutorisationDactiviteController@massDestroy')->name('autorisation-dactivites.massDestroy');
    Route::post('autorisation-dactivites/media', 'AutorisationDactiviteController@storeMedia')->name('autorisation-dactivites.storeMedia');
    Route::post('autorisation-dactivites/ckmedia', 'AutorisationDactiviteController@storeCKEditorImages')->name('autorisation-dactivites.storeCKEditorImages');
    Route::post('autorisation-dactivites/parse-csv-import', 'AutorisationDactiviteController@parseCsvImport')->name('autorisation-dactivites.parseCsvImport');
    Route::post('autorisation-dactivites/process-csv-import', 'AutorisationDactiviteController@processCsvImport')->name('autorisation-dactivites.processCsvImport');
    Route::resource('autorisation-dactivites', 'AutorisationDactiviteController');

    // Dossier Assurances
    Route::delete('dossier-assurances/destroy', 'DossierAssuranceController@massDestroy')->name('dossier-assurances.massDestroy');
    Route::post('dossier-assurances/media', 'DossierAssuranceController@storeMedia')->name('dossier-assurances.storeMedia');
    Route::post('dossier-assurances/ckmedia', 'DossierAssuranceController@storeCKEditorImages')->name('dossier-assurances.storeCKEditorImages');
    Route::post('dossier-assurances/parse-csv-import', 'DossierAssuranceController@parseCsvImport')->name('dossier-assurances.parseCsvImport');
    Route::post('dossier-assurances/process-csv-import', 'DossierAssuranceController@processCsvImport')->name('dossier-assurances.processCsvImport');
    Route::resource('dossier-assurances', 'DossierAssuranceController');

    // Autre Documents
    Route::delete('autre-documents/destroy', 'AutreDocumentsController@massDestroy')->name('autre-documents.massDestroy');
    Route::post('autre-documents/media', 'AutreDocumentsController@storeMedia')->name('autre-documents.storeMedia');
    Route::post('autre-documents/ckmedia', 'AutreDocumentsController@storeCKEditorImages')->name('autre-documents.storeCKEditorImages');
    Route::post('autre-documents/parse-csv-import', 'AutreDocumentsController@parseCsvImport')->name('autre-documents.parseCsvImport');
    Route::post('autre-documents/process-csv-import', 'AutreDocumentsController@processCsvImport')->name('autre-documents.processCsvImport');
    Route::resource('autre-documents', 'AutreDocumentsController');

    // Declaration Tvas
    Route::delete('declaration-tvas/destroy', 'DeclarationTvaController@massDestroy')->name('declaration-tvas.massDestroy');
    Route::post('declaration-tvas/media', 'DeclarationTvaController@storeMedia')->name('declaration-tvas.storeMedia');
    Route::post('declaration-tvas/ckmedia', 'DeclarationTvaController@storeCKEditorImages')->name('declaration-tvas.storeCKEditorImages');
    Route::post('declaration-tvas/parse-csv-import', 'DeclarationTvaController@parseCsvImport')->name('declaration-tvas.parseCsvImport');
    Route::post('declaration-tvas/process-csv-import', 'DeclarationTvaController@processCsvImport')->name('declaration-tvas.processCsvImport');
    Route::resource('declaration-tvas', 'DeclarationTvaController');

    // Bilans
    Route::delete('bilans/destroy', 'BilanController@massDestroy')->name('bilans.massDestroy');
    Route::post('bilans/media', 'BilanController@storeMedia')->name('bilans.storeMedia');
    Route::post('bilans/ckmedia', 'BilanController@storeCKEditorImages')->name('bilans.storeCKEditorImages');
    Route::post('bilans/parse-csv-import', 'BilanController@parseCsvImport')->name('bilans.parseCsvImport');
    Route::post('bilans/process-csv-import', 'BilanController@processCsvImport')->name('bilans.processCsvImport');
    Route::resource('bilans', 'BilanController');

    // Ir Sur Salaires
    Route::delete('ir-sur-salaires/destroy', 'IrSurSalaireController@massDestroy')->name('ir-sur-salaires.massDestroy');
    Route::post('ir-sur-salaires/media', 'IrSurSalaireController@storeMedia')->name('ir-sur-salaires.storeMedia');
    Route::post('ir-sur-salaires/ckmedia', 'IrSurSalaireController@storeCKEditorImages')->name('ir-sur-salaires.storeCKEditorImages');
    Route::post('ir-sur-salaires/parse-csv-import', 'IrSurSalaireController@parseCsvImport')->name('ir-sur-salaires.parseCsvImport');
    Route::post('ir-sur-salaires/process-csv-import', 'IrSurSalaireController@processCsvImport')->name('ir-sur-salaires.processCsvImport');
    Route::resource('ir-sur-salaires', 'IrSurSalaireController');

    // Pv Tribunals
    Route::delete('pv-tribunals/destroy', 'PvTribunalController@massDestroy')->name('pv-tribunals.massDestroy');
    Route::post('pv-tribunals/media', 'PvTribunalController@storeMedia')->name('pv-tribunals.storeMedia');
    Route::post('pv-tribunals/ckmedia', 'PvTribunalController@storeCKEditorImages')->name('pv-tribunals.storeCKEditorImages');
    Route::post('pv-tribunals/parse-csv-import', 'PvTribunalController@parseCsvImport')->name('pv-tribunals.parseCsvImport');
    Route::post('pv-tribunals/process-csv-import', 'PvTribunalController@processCsvImport')->name('pv-tribunals.processCsvImport');
    Route::resource('pv-tribunals', 'PvTribunalController');

    // Rapprochement Bancaires
    Route::delete('rapprochement-bancaires/destroy', 'RapprochementBancaireController@massDestroy')->name('rapprochement-bancaires.massDestroy');
    Route::post('rapprochement-bancaires/media', 'RapprochementBancaireController@storeMedia')->name('rapprochement-bancaires.storeMedia');
    Route::post('rapprochement-bancaires/ckmedia', 'RapprochementBancaireController@storeCKEditorImages')->name('rapprochement-bancaires.storeCKEditorImages');
    Route::post('rapprochement-bancaires/parse-csv-import', 'RapprochementBancaireController@parseCsvImport')->name('rapprochement-bancaires.parseCsvImport');
    Route::post('rapprochement-bancaires/process-csv-import', 'RapprochementBancaireController@processCsvImport')->name('rapprochement-bancaires.processCsvImport');
    Route::resource('rapprochement-bancaires', 'RapprochementBancaireController');

    // Balances
    Route::delete('balances/destroy', 'BalanceController@massDestroy')->name('balances.massDestroy');
    Route::post('balances/media', 'BalanceController@storeMedia')->name('balances.storeMedia');
    Route::post('balances/ckmedia', 'BalanceController@storeCKEditorImages')->name('balances.storeCKEditorImages');
    Route::post('balances/parse-csv-import', 'BalanceController@parseCsvImport')->name('balances.parseCsvImport');
    Route::post('balances/process-csv-import', 'BalanceController@processCsvImport')->name('balances.processCsvImport');
    Route::resource('balances', 'BalanceController');

    // Etat Des Horaires
    Route::delete('etat-des-horaires/destroy', 'EtatDesHorairesController@massDestroy')->name('etat-des-horaires.massDestroy');
    Route::post('etat-des-horaires/media', 'EtatDesHorairesController@storeMedia')->name('etat-des-horaires.storeMedia');
    Route::post('etat-des-horaires/ckmedia', 'EtatDesHorairesController@storeCKEditorImages')->name('etat-des-horaires.storeCKEditorImages');
    Route::post('etat-des-horaires/parse-csv-import', 'EtatDesHorairesController@parseCsvImport')->name('etat-des-horaires.parseCsvImport');
    Route::post('etat-des-horaires/process-csv-import', 'EtatDesHorairesController@processCsvImport')->name('etat-des-horaires.processCsvImport');
    Route::resource('etat-des-horaires', 'EtatDesHorairesController');

    // Grand Livres
    Route::delete('grand-livres/destroy', 'GrandLivreController@massDestroy')->name('grand-livres.massDestroy');
    Route::post('grand-livres/media', 'GrandLivreController@storeMedia')->name('grand-livres.storeMedia');
    Route::post('grand-livres/ckmedia', 'GrandLivreController@storeCKEditorImages')->name('grand-livres.storeCKEditorImages');
    Route::post('grand-livres/parse-csv-import', 'GrandLivreController@parseCsvImport')->name('grand-livres.parseCsvImport');
    Route::post('grand-livres/process-csv-import', 'GrandLivreController@processCsvImport')->name('grand-livres.processCsvImport');
    Route::resource('grand-livres', 'GrandLivreController');

    // Liste Des Moyens
    Route::delete('liste-des-moyens/destroy', 'ListeDesMoyensController@massDestroy')->name('liste-des-moyens.massDestroy');
    Route::post('liste-des-moyens/media', 'ListeDesMoyensController@storeMedia')->name('liste-des-moyens.storeMedia');
    Route::post('liste-des-moyens/ckmedia', 'ListeDesMoyensController@storeCKEditorImages')->name('liste-des-moyens.storeCKEditorImages');
    Route::post('liste-des-moyens/parse-csv-import', 'ListeDesMoyensController@parseCsvImport')->name('liste-des-moyens.parseCsvImport');
    Route::post('liste-des-moyens/process-csv-import', 'ListeDesMoyensController@processCsvImport')->name('liste-des-moyens.processCsvImport');
    Route::resource('liste-des-moyens', 'ListeDesMoyensController');

    // Autres
    Route::delete('autres/destroy', 'AutresController@massDestroy')->name('autres.massDestroy');
    Route::post('autres/media', 'AutresController@storeMedia')->name('autres.storeMedia');
    Route::post('autres/ckmedia', 'AutresController@storeCKEditorImages')->name('autres.storeCKEditorImages');
    Route::post('autres/parse-csv-import', 'AutresController@parseCsvImport')->name('autres.parseCsvImport');
    Route::post('autres/process-csv-import', 'AutresController@processCsvImport')->name('autres.processCsvImport');
    Route::resource('autres', 'AutresController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::post('user-alerts/parse-csv-import', 'UserAlertsController@parseCsvImport')->name('user-alerts.parseCsvImport');
    Route::post('user-alerts/process-csv-import', 'UserAlertsController@processCsvImport')->name('user-alerts.processCsvImport');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
