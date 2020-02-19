<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li>
                    <select class="searchable-field form-control">

                    </select>
                </li>
                <li class="nav-item">
                    <a href="{{ route("admin.home") }}" class="nav-link">
                        <p>
                            <i class="fas fa-fw fa-tachometer-alt">

                            </i>
                            <span>{{ trans('global.dashboard') }}</span>
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }} {{ request()->is('admin/audit-logs*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-users">

                            </i>
                            <p>
                                <span>{{ trans('cruds.userManagement.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.permission.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-briefcase">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.role.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-user">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.user.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-file-alt">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.auditLog.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('dossier_juridique_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/statuts*') ? 'menu-open' : '' }} {{ request()->is('admin/registre-de-commerces*') ? 'menu-open' : '' }} {{ request()->is('admin/taxe-professionnelles*') ? 'menu-open' : '' }} {{ request()->is('admin/certificat-negatifs*') ? 'menu-open' : '' }} {{ request()->is('admin/identifiant-fiscals*') ? 'menu-open' : '' }} {{ request()->is('admin/cingerants*') ? 'menu-open' : '' }} {{ request()->is('admin/pv-pouvoirs*') ? 'menu-open' : '' }} {{ request()->is('admin/autorisation-dactivites*') ? 'menu-open' : '' }} {{ request()->is('admin/dossier-assurances*') ? 'menu-open' : '' }} {{ request()->is('admin/autre-documents*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-gavel">

                            </i>
                            <p>
                                <span>{{ trans('cruds.dossierJuridique.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('statut_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.statuts.index") }}" class="nav-link {{ request()->is('admin/statuts') || request()->is('admin/statuts/*') ? 'active' : '' }}">
                                        <i class="fa-fw far fa-address-card">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.statut.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('registre_de_commerce_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.registre-de-commerces.index") }}" class="nav-link {{ request()->is('admin/registre-de-commerces') || request()->is('admin/registre-de-commerces/*') ? 'active' : '' }}">
                                        <i class="fa-fw far fa-clone">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.registreDeCommerce.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('taxe_professionnelle_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.taxe-professionnelles.index") }}" class="nav-link {{ request()->is('admin/taxe-professionnelles') || request()->is('admin/taxe-professionnelles/*') ? 'active' : '' }}">
                                        <i class="fa-fw fab fa-500px">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.taxeProfessionnelle.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('certificat_negatif_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.certificat-negatifs.index") }}" class="nav-link {{ request()->is('admin/certificat-negatifs') || request()->is('admin/certificat-negatifs/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-certificate">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.certificatNegatif.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('identifiant_fiscal_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.identifiant-fiscals.index") }}" class="nav-link {{ request()->is('admin/identifiant-fiscals') || request()->is('admin/identifiant-fiscals/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-money-check-alt">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.identifiantFiscal.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('cingerant_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.cingerants.index") }}" class="nav-link {{ request()->is('admin/cingerants') || request()->is('admin/cingerants/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-chess-knight">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.cingerant.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('pv_pouvoir_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.pv-pouvoirs.index") }}" class="nav-link {{ request()->is('admin/pv-pouvoirs') || request()->is('admin/pv-pouvoirs/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-plug">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.pvPouvoir.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('autorisation_dactivite_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.autorisation-dactivites.index") }}" class="nav-link {{ request()->is('admin/autorisation-dactivites') || request()->is('admin/autorisation-dactivites/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-magic">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.autorisationDactivite.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('dossier_assurance_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.dossier-assurances.index") }}" class="nav-link {{ request()->is('admin/dossier-assurances') || request()->is('admin/dossier-assurances/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-bug">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.dossierAssurance.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('autre_document_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.autre-documents.index") }}" class="nav-link {{ request()->is('admin/autre-documents') || request()->is('admin/autre-documents/*') ? 'active' : '' }}">
                                        <i class="fa-fw far fa-calendar-minus">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.autreDocument.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('dossier_comptable_et_fiscal_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/declaration-tvas*') ? 'menu-open' : '' }} {{ request()->is('admin/bilans*') ? 'menu-open' : '' }} {{ request()->is('admin/ir-sur-salaires*') ? 'menu-open' : '' }} {{ request()->is('admin/pv-tribunals*') ? 'menu-open' : '' }} {{ request()->is('admin/rapprochement-bancaires*') ? 'menu-open' : '' }} {{ request()->is('admin/balances*') ? 'menu-open' : '' }} {{ request()->is('admin/etat-des-horaires*') ? 'menu-open' : '' }} {{ request()->is('admin/grand-livres*') ? 'menu-open' : '' }} {{ request()->is('admin/liste-des-moyens*') ? 'menu-open' : '' }} {{ request()->is('admin/autres*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw fas fa-hand-holding-usd">

                            </i>
                            <p>
                                <span>{{ trans('cruds.dossierComptableEtFiscal.title') }}</span>
                                <i class="right fa fa-fw fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('declaration_tva_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.declaration-tvas.index") }}" class="nav-link {{ request()->is('admin/declaration-tvas') || request()->is('admin/declaration-tvas/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-bullhorn">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.declarationTva.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('bilan_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.bilans.index") }}" class="nav-link {{ request()->is('admin/bilans') || request()->is('admin/bilans/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-bold">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.bilan.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('ir_sur_salaire_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.ir-sur-salaires.index") }}" class="nav-link {{ request()->is('admin/ir-sur-salaires') || request()->is('admin/ir-sur-salaires/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-child">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.irSurSalaire.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('pv_tribunal_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.pv-tribunals.index") }}" class="nav-link {{ request()->is('admin/pv-tribunals') || request()->is('admin/pv-tribunals/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-gavel">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.pvTribunal.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('rapprochement_bancaire_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.rapprochement-bancaires.index") }}" class="nav-link {{ request()->is('admin/rapprochement-bancaires') || request()->is('admin/rapprochement-bancaires/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-university">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.rapprochementBancaire.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('balance_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.balances.index") }}" class="nav-link {{ request()->is('admin/balances') || request()->is('admin/balances/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-balance-scale">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.balance.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('etat_des_horaire_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.etat-des-horaires.index") }}" class="nav-link {{ request()->is('admin/etat-des-horaires') || request()->is('admin/etat-des-horaires/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-stopwatch">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.etatDesHoraire.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('grand_livre_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.grand-livres.index") }}" class="nav-link {{ request()->is('admin/grand-livres') || request()->is('admin/grand-livres/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-book">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.grandLivre.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('liste_des_moyen_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.liste-des-moyens.index") }}" class="nav-link {{ request()->is('admin/liste-des-moyens') || request()->is('admin/liste-des-moyens/*') ? 'active' : '' }}">
                                        <i class="fa-fw far fa-list-alt">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.listeDesMoyen.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('autre_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.autres.index") }}" class="nav-link {{ request()->is('admin/autres') || request()->is('admin/autres/*') ? 'active' : '' }}">
                                        <i class="fa-fw fas fa-clipboard-check">

                                        </i>
                                        <p>
                                            <span>{{ trans('cruds.autre.title') }}</span>
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user_alert_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.user-alerts.index") }}" class="nav-link {{ request()->is('admin/user-alerts') || request()->is('admin/user-alerts/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-bell">

                            </i>
                            <p>
                                <span>{{ trans('cruds.userAlert.title') }}</span>
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt">

                            </i>
                            <span>{{ trans('global.logout') }}</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>