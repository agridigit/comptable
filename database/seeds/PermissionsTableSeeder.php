<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_create',
            ],
            [
                'id'    => '3',
                'title' => 'permission_edit',
            ],
            [
                'id'    => '4',
                'title' => 'permission_show',
            ],
            [
                'id'    => '5',
                'title' => 'permission_delete',
            ],
            [
                'id'    => '6',
                'title' => 'permission_access',
            ],
            [
                'id'    => '7',
                'title' => 'role_create',
            ],
            [
                'id'    => '8',
                'title' => 'role_edit',
            ],
            [
                'id'    => '9',
                'title' => 'role_show',
            ],
            [
                'id'    => '10',
                'title' => 'role_delete',
            ],
            [
                'id'    => '11',
                'title' => 'role_access',
            ],
            [
                'id'    => '12',
                'title' => 'user_create',
            ],
            [
                'id'    => '13',
                'title' => 'user_edit',
            ],
            [
                'id'    => '14',
                'title' => 'user_show',
            ],
            [
                'id'    => '15',
                'title' => 'user_delete',
            ],
            [
                'id'    => '16',
                'title' => 'user_access',
            ],
            [
                'id'    => '17',
                'title' => 'dossier_juridique_access',
            ],
            [
                'id'    => '18',
                'title' => 'statut_create',
            ],
            [
                'id'    => '19',
                'title' => 'statut_edit',
            ],
            [
                'id'    => '20',
                'title' => 'statut_show',
            ],
            [
                'id'    => '21',
                'title' => 'statut_delete',
            ],
            [
                'id'    => '22',
                'title' => 'statut_access',
            ],
            [
                'id'    => '23',
                'title' => 'registre_de_commerce_create',
            ],
            [
                'id'    => '24',
                'title' => 'registre_de_commerce_edit',
            ],
            [
                'id'    => '25',
                'title' => 'registre_de_commerce_show',
            ],
            [
                'id'    => '26',
                'title' => 'registre_de_commerce_delete',
            ],
            [
                'id'    => '27',
                'title' => 'registre_de_commerce_access',
            ],
            [
                'id'    => '28',
                'title' => 'taxe_professionnelle_create',
            ],
            [
                'id'    => '29',
                'title' => 'taxe_professionnelle_edit',
            ],
            [
                'id'    => '30',
                'title' => 'taxe_professionnelle_show',
            ],
            [
                'id'    => '31',
                'title' => 'taxe_professionnelle_delete',
            ],
            [
                'id'    => '32',
                'title' => 'taxe_professionnelle_access',
            ],
            [
                'id'    => '33',
                'title' => 'certificat_negatif_create',
            ],
            [
                'id'    => '34',
                'title' => 'certificat_negatif_edit',
            ],
            [
                'id'    => '35',
                'title' => 'certificat_negatif_show',
            ],
            [
                'id'    => '36',
                'title' => 'certificat_negatif_delete',
            ],
            [
                'id'    => '37',
                'title' => 'certificat_negatif_access',
            ],
            [
                'id'    => '38',
                'title' => 'identifiant_fiscal_create',
            ],
            [
                'id'    => '39',
                'title' => 'identifiant_fiscal_edit',
            ],
            [
                'id'    => '40',
                'title' => 'identifiant_fiscal_show',
            ],
            [
                'id'    => '41',
                'title' => 'identifiant_fiscal_delete',
            ],
            [
                'id'    => '42',
                'title' => 'identifiant_fiscal_access',
            ],
            [
                'id'    => '43',
                'title' => 'cingerant_create',
            ],
            [
                'id'    => '44',
                'title' => 'cingerant_edit',
            ],
            [
                'id'    => '45',
                'title' => 'cingerant_show',
            ],
            [
                'id'    => '46',
                'title' => 'cingerant_delete',
            ],
            [
                'id'    => '47',
                'title' => 'cingerant_access',
            ],
            [
                'id'    => '48',
                'title' => 'pv_pouvoir_create',
            ],
            [
                'id'    => '49',
                'title' => 'pv_pouvoir_edit',
            ],
            [
                'id'    => '50',
                'title' => 'pv_pouvoir_show',
            ],
            [
                'id'    => '51',
                'title' => 'pv_pouvoir_delete',
            ],
            [
                'id'    => '52',
                'title' => 'pv_pouvoir_access',
            ],
            [
                'id'    => '53',
                'title' => 'autorisation_dactivite_create',
            ],
            [
                'id'    => '54',
                'title' => 'autorisation_dactivite_edit',
            ],
            [
                'id'    => '55',
                'title' => 'autorisation_dactivite_show',
            ],
            [
                'id'    => '56',
                'title' => 'autorisation_dactivite_delete',
            ],
            [
                'id'    => '57',
                'title' => 'autorisation_dactivite_access',
            ],
            [
                'id'    => '58',
                'title' => 'dossier_assurance_create',
            ],
            [
                'id'    => '59',
                'title' => 'dossier_assurance_edit',
            ],
            [
                'id'    => '60',
                'title' => 'dossier_assurance_show',
            ],
            [
                'id'    => '61',
                'title' => 'dossier_assurance_delete',
            ],
            [
                'id'    => '62',
                'title' => 'dossier_assurance_access',
            ],
            [
                'id'    => '63',
                'title' => 'autre_document_create',
            ],
            [
                'id'    => '64',
                'title' => 'autre_document_edit',
            ],
            [
                'id'    => '65',
                'title' => 'autre_document_show',
            ],
            [
                'id'    => '66',
                'title' => 'autre_document_delete',
            ],
            [
                'id'    => '67',
                'title' => 'autre_document_access',
            ],
            [
                'id'    => '68',
                'title' => 'dossier_comptable_et_fiscal_access',
            ],
            [
                'id'    => '69',
                'title' => 'declaration_tva_create',
            ],
            [
                'id'    => '70',
                'title' => 'declaration_tva_edit',
            ],
            [
                'id'    => '71',
                'title' => 'declaration_tva_show',
            ],
            [
                'id'    => '72',
                'title' => 'declaration_tva_delete',
            ],
            [
                'id'    => '73',
                'title' => 'declaration_tva_access',
            ],
            [
                'id'    => '74',
                'title' => 'bilan_create',
            ],
            [
                'id'    => '75',
                'title' => 'bilan_edit',
            ],
            [
                'id'    => '76',
                'title' => 'bilan_show',
            ],
            [
                'id'    => '77',
                'title' => 'bilan_delete',
            ],
            [
                'id'    => '78',
                'title' => 'bilan_access',
            ],
            [
                'id'    => '79',
                'title' => 'ir_sur_salaire_create',
            ],
            [
                'id'    => '80',
                'title' => 'ir_sur_salaire_edit',
            ],
            [
                'id'    => '81',
                'title' => 'ir_sur_salaire_show',
            ],
            [
                'id'    => '82',
                'title' => 'ir_sur_salaire_delete',
            ],
            [
                'id'    => '83',
                'title' => 'ir_sur_salaire_access',
            ],
            [
                'id'    => '84',
                'title' => 'pv_tribunal_create',
            ],
            [
                'id'    => '85',
                'title' => 'pv_tribunal_edit',
            ],
            [
                'id'    => '86',
                'title' => 'pv_tribunal_show',
            ],
            [
                'id'    => '87',
                'title' => 'pv_tribunal_delete',
            ],
            [
                'id'    => '88',
                'title' => 'pv_tribunal_access',
            ],
            [
                'id'    => '89',
                'title' => 'rapprochement_bancaire_create',
            ],
            [
                'id'    => '90',
                'title' => 'rapprochement_bancaire_edit',
            ],
            [
                'id'    => '91',
                'title' => 'rapprochement_bancaire_show',
            ],
            [
                'id'    => '92',
                'title' => 'rapprochement_bancaire_delete',
            ],
            [
                'id'    => '93',
                'title' => 'rapprochement_bancaire_access',
            ],
            [
                'id'    => '94',
                'title' => 'balance_create',
            ],
            [
                'id'    => '95',
                'title' => 'balance_edit',
            ],
            [
                'id'    => '96',
                'title' => 'balance_show',
            ],
            [
                'id'    => '97',
                'title' => 'balance_delete',
            ],
            [
                'id'    => '98',
                'title' => 'balance_access',
            ],
            [
                'id'    => '99',
                'title' => 'etat_des_horaire_create',
            ],
            [
                'id'    => '100',
                'title' => 'etat_des_horaire_edit',
            ],
            [
                'id'    => '101',
                'title' => 'etat_des_horaire_show',
            ],
            [
                'id'    => '102',
                'title' => 'etat_des_horaire_delete',
            ],
            [
                'id'    => '103',
                'title' => 'etat_des_horaire_access',
            ],
            [
                'id'    => '104',
                'title' => 'grand_livre_create',
            ],
            [
                'id'    => '105',
                'title' => 'grand_livre_edit',
            ],
            [
                'id'    => '106',
                'title' => 'grand_livre_show',
            ],
            [
                'id'    => '107',
                'title' => 'grand_livre_delete',
            ],
            [
                'id'    => '108',
                'title' => 'grand_livre_access',
            ],
            [
                'id'    => '109',
                'title' => 'liste_des_moyen_create',
            ],
            [
                'id'    => '110',
                'title' => 'liste_des_moyen_edit',
            ],
            [
                'id'    => '111',
                'title' => 'liste_des_moyen_show',
            ],
            [
                'id'    => '112',
                'title' => 'liste_des_moyen_delete',
            ],
            [
                'id'    => '113',
                'title' => 'liste_des_moyen_access',
            ],
            [
                'id'    => '114',
                'title' => 'autre_create',
            ],
            [
                'id'    => '115',
                'title' => 'autre_edit',
            ],
            [
                'id'    => '116',
                'title' => 'autre_show',
            ],
            [
                'id'    => '117',
                'title' => 'autre_delete',
            ],
            [
                'id'    => '118',
                'title' => 'autre_access',
            ],
            [
                'id'    => '119',
                'title' => 'dossier_grh_access',
            ],
            [
                'id'    => '120',
                'title' => 'audit_log_show',
            ],
            [
                'id'    => '121',
                'title' => 'audit_log_access',
            ],
            [
                'id'    => '122',
                'title' => 'user_alert_create',
            ],
            [
                'id'    => '123',
                'title' => 'user_alert_show',
            ],
            [
                'id'    => '124',
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => '125',
                'title' => 'user_alert_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
