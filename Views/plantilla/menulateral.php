<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link " href="<?= BASE_URL ?>index">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

      <?php
    if (Sessiones::accesoVista('protagonista')) {
      ?>
    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>medicacion">
        <i class="fa-solid fa-pills"></i>
        <span>Medicacion</span>
      </a>
    </li><!-- End Dashboard Nav -->

     <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>alimentacion">
        <i class="fa-solid fa-utensils"></i>
        <span>Alimentacion</span>
      </a>
    </li><!-- End Dashboard Nav -->

     <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>ejercicio">
        <i class="fa-solid fa-dumbbell"></i>
        <span>Ejercicio</span>
       
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>ayuda">
       <i class="fa-solid fa-brain"></i>
        <span>Ayuda Psicologica</span>
       
      </a>
    </li><!-- End Dashboard Nav -->

    
     <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>biblioteca">
        <i class="fa-solid fa-book"></i>
        <span>Biblioteca</span>
      </a>
    </li><!-- End Dashboard Nav -->

     <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>registro">
        <i class="fa-solid fa-file-circle-plus"></i>
        <span>Registrar Signos</span>
      </a>
    </li><!-- End Dashboard Nav -->





    


   

        <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>reserva">
       <i class="fa-solid fa-calendar"></i>
        <span>Reservar Cita</span>
      </a>
    </li><!-- End Dashboard Nav -->

        <?php } ?>




    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>buscar">
      <i class="fa-solid fa-search"></i>
        <span>Buscar</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <?php
    if (Sessiones::getVista('administrador')) {
      ?>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?= BASE_URL ?>usuario">
          <i class="fa-solid fa-user"></i>
          <span>Usuario</span>
        </a>
      </li><!-- End Dashboard Nav -->

 <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>doctor">
        <i class="fa-solid fa-stethoscope"></i>
        <span>Doctor</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>protagonista">
        <i class="fa-solid fa-hospital-user"></i>
        <span>Protagonista</span>
      </a>
    </li><!-- End Dashboard Nav -->





     

       <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>medicacion">
        <i class="fa-solid fa-pills"></i>
        <span>Medicacion</span>
      </a>
    </li><!-- End Dashboard Nav -->

     <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>alimentacion">
        <i class="fa-solid fa-utensils"></i>
        <span>Alimentacion</span>
      </a>
    </li><!-- End Dashboard Nav -->

     <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>ejercicio">
        <i class="fa-solid fa-dumbbell"></i>
        <span>Ejercicio</span>
       
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="<?= BASE_URL ?>reportes">
        <i class="fa-solid fa-save"></i>
        <span>Reportes</span>
       
      </a>
    </li><!-- End Dashboard Nav -->

   

    
    
      
      <!-- End Dashboard Nav -->
    
    
    
    
    
    <!-- End Forms Nav -->






      <!-- End Dashboard Nav -->
    <?php } ?>

    <?php
    if (Sessiones::accesoVista('familiar')) {
      ?>

    <li class="nav-item">
        <a class="nav-link collapsed" href="<?= BASE_URL ?>recuerdo">
        <i class="fa-solid fa-people-roof"></i>
          <span>Recuerdo</span>
        </a>
      </li><!-- End Dashboard Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="<?= BASE_URL ?>solicitar">
        <i class="fa-solid fa-money-bill"></i>
          <span>Solicitar Servicio</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <?php } ?>


    <?php
    if (Sessiones::getClave('autenticado')) {
      echo '
      <li class="nav-item">
        <a class="nav-link collapsed" href="' . BASE_URL . 'login/salir">
        <i class="fa-solid fa-right-from-bracket"></i>
          <span>Salir</span>
        </a>
      </li>';
    } else {
      echo '
      <li class="nav-item">
        <a class="nav-link collapsed" href="' . BASE_URL . 'login">
        <i class="fa-solid fa-right-to-bracket"></i>
          <span>Ingresar</span>
        </a>
      </li>';
    }
    ?>

   

    

  </ul>

</aside><!-- End Sidebar-->