<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<!-- Bootstrap row -->
    <div class="row" id="body-row">
        <!-- Sidebar -->
        <div id="sidebar-container" class="sidebar-expanded bg-theme3 d-none d-md-block">
            <!-- d-* hiddens the Sidebar in smaller devices. Its items can be kept on the Navbar 'Menu' -->
            <!-- Bootstrap List Group -->
            <ul class="list-group sticky-top sticky-offset">
                <!-- Separator with title -->
                <li class="list-group-item bg-theme3 sidebar-separator-title d-flex align-items-center menu-collapsed">
                    <small>MAIN MENU</small>
                </li>
                <!-- /END Separator -->
                <!-- Submenu 1-->
                <?php if($row_user['Tipo_Usuario'] ==  'Gerente'){ ?>
                <a href="#submenu1" data-toggle="collapse" aria-expanded="false" class="bg-theme2 list-group-item list-group-item-action d-flex">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-book fa-fw mr-3"></span>
                        <span class="menu-collapsed">Registros</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- Submenu 1 content -->
                <div id="submenu1" class="collapse sidebar-submenu">
                    <a href="personal.php?user=<?php echo $id;?>" class="list-group-item list-group-item-action bg-theme2 text-white">
                        <span class="menu-collapsed">Personal</span>
                    </a>
                    <a href="inventario.php?user=<?php echo $id;?>" class="list-group-item list-group-item-action bg-theme2 text-white">
                        <span class="menu-collapsed">Inventario</span>
                    </a>
                    <a href="restinfo.php?user=<?php echo $id;?>" class="list-group-item list-group-item-action bg-theme2 text-white">
                        <span class="menu-collapsed">Información del restaurante</span>
                    </a>
                </div>
                <?php }?>

                <!-- Submenu 2-->
                <a href="#submenu2" data-toggle="collapse" aria-expanded="false" class="bg-theme2 list-group-item list-group-item-action d-flex">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-utensils fa-fw mr-3"></span> 
                        <span class="menu-collapsed">Restaurante</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- Submenu 2 content -->
                <div id="submenu2" class="collapse sidebar-submenu">
                    <?php if($row_user['Tipo_Usuario'] !=  'Cliente'){ ?>
                    <a href="mesas.php?user=<?php echo $id;?>" class="list-group-item list-group-item-action bg-theme2 text-white">
                        <span class="menu-collapsed">Mesas</span>
                    </a>
                     <?php }?>
                    <a href="pedidos_activos.php?user=<?php echo $id;?>" class="list-group-item list-group-item-action bg-theme2 text-white">
                        <span class="menu-collapsed">Pedidos Activos</span>
                    </a>
                    <a href="menu_restaurante.php?user=<?php echo $id;?>" class="list-group-item list-group-item-action bg-theme2 text-white">
                        <span class="menu-collapsed">Menu</span>
                    </a>
                </div>

                <!-- Submenu 3-->
                <?php if($row_user['Tipo_Usuario'] !=  'Cliente'){ ?>
                <a href="#submenu3" data-toggle="collapse" aria-expanded="false" class="bg-theme2 list-group-item list-group-item-action d-flex">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-clipboard fa-fw mr-3"></span>
                        <span class="menu-collapsed">Utilidades</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- Submenu 3 content -->
                <div id="submenu3" class="collapse sidebar-submenu">
                    <a href="actividades.php?user=<?php echo $id;?>" class="list-group-item list-group-item-action bg-theme2 text-white">
                        <span class="menu-collapsed">Actividades</span>
                    </a>

                    <?php if($row_user['Tipo_Usuario'] ==  'Gerente' | $row_user['Tipo_Usuario'] == 'Cajero'){ ?>
                    <a href="reportes.php?user=<?php echo $id;?>" class="list-group-item list-group-item-action bg-theme2 text-white">
                        <span class="menu-collapsed">Reportes</span>
                    </a>
                    <?php }?>
                </div>
                <?php }?>

                <!-- Submenu 4-->
                <?php if($row_user['Tipo_Usuario'] ==  'Gerente' | $row_user['Tipo_Usuario'] ==  'Cliente'){ ?>
                <a href="#submenu4" data-toggle="collapse" aria-expanded="false" class="bg-theme2 list-group-item list-group-item-action d-flex">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-comments fa-fw mr-3"></span>
                        <span class="menu-collapsed">Reseñas</span>
                        <span class="submenu-icon ml-auto"></span>
                    </div>
                </a>
                <!-- Submenu 4 content -->
                <div id="submenu4" class="collapse sidebar-submenu">
                    <a href="comentarios.php?user=<?php echo $id;?>" class="list-group-item list-group-item-action bg-theme2 text-white">
                        <span class="menu-collapsed">Comentarios</span>
                    </a>
                </div>
                <?php }?>
                

                <!-- Separator with title -->
                <li class="list-group-item bg-theme3 sidebar-separator-title d-flex align-items-center menu-collapsed">
                    <small>OPTIONS</small>
                </li>
                <!-- /END Separator -->
                <a href="#" class="bg-theme2 list-group-item list-group-item-action d-flex">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-cog fa-fw mr-3"></span>
                        <span class="menu-collapsed">Settings</span>
                    </div>
                </a>
                
                
                <a href="#" data-toggle="sidebar-collapse" class="bg-theme2 list-group-item list-group-item-action d-flex">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span id="collapse-icon" class="fa fas fa-arrow-alt-circle-left mr-3"></span>
                        <span id="collapse-text" class="menu-collapsed">Collapse</span>
                    </div>
                </a>
                <!-- Logo -->
                <li class="list-group-item bg-theme3 logo-separator d-flex justify-content-center">
                    
                </li>
            </ul>
            <!-- List Group END-->
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="../js/main.js"></script>
</body>
</html>