    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media(); ?>/images/avatar.png" alt="User Image">
            <div>
                <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres']; ?></p>
                <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol']; ?></p>
            </div>
        </div>
        <ul class="app-menu">
            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>" target="_blank">
                    <i class="app-menu__icon fa fas fa-globe" aria-hidden="true"></i>
                    <span class="app-menu__label">Ver sitio web</span>
                </a>
            </li>
            <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
                <li>
                    <a class="app-menu__item" href="<?= base_url(); ?>/dashboard">
                        <i class="app-menu__icon fa fa-dashboard"></i>
                        <span class="app-menu__label">Dashboard</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
                <li class="treeview">
                    <a class="app-menu__item" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
                        <span class="app-menu__label">Usuarios</span>
                        <i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a class="treeview-item" href="<?= base_url(); ?>/usuarios"><i class="icon fa fa-circle-o"></i> Usuarios</a></li>
                        <li><a class="treeview-item" href="<?= base_url(); ?>/roles"><i class="icon fa fa-circle-o"></i> Roles</a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                <li>
                    <a class="app-menu__item" href="<?= base_url(); ?>/paciente">
                        <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
                        <span class="app-menu__label">Paciente</span>
                    </a>
                </li>
            <?php } ?>


            <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                <li>
                    <a class="app-menu__item" href="<?= base_url(); ?>/cita">
                        <i class="app-menu__icon fas fa-calendar-alt" aria-hidden="true"></i>
                        <span class="app-menu__label">Citas</span>
                    </a>

                </li>
            <?php } ?>


            <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                <li>
                    <a class="app-menu__item" href="<?= base_url(); ?>/servicio">
                        <i class="app-menu__icon fas fa-cogs" aria-hidden="true"></i>
                        <span class="app-menu__label">Servicios</span>
                    </a>

                </li>
            <?php } ?>


            <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                <li>
                    <a class="app-menu__item" href="<?= base_url(); ?>/recordatorio">
                        <i class="app-menu__icon fas fa-hand-point-up" aria-hidden="true"></i>
                        <span class="app-menu__label">Recordatorios</span>
                    </a>

                </li>
            <?php } ?>

            <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
                <li>
                    <a class="app-menu__item" href="<?= base_url(); ?>/historial">
                        <i class="app-menu__icon fas fa-file-medical" aria-hidden="true"></i>
                        <span class="app-menu__label">Historial</span>
                    </a>

                </li>
            <?php } ?>

            <li>
                <a class="app-menu__item" href="<?= base_url(); ?>/logout">
                    <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
                    <span class="app-menu__label">Logout</span>
                </a>
            </li>
        </ul>
    </aside>