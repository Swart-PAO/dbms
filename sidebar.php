 <?php
    $currentPage = $_GET['page'] ?? 'home';
    ?>
 <div class="sidebar px-4 py-4 py-md-5 me-0">
     <div class="d-flex flex-column h-100">
         <a href="index.html" class="mb-0 brand-icon">
             <span class="logo-icon">
                 <svg width="35" height="35" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                     <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                     <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                     <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                 </svg>
             </span>
             <span class="logo-text">LBMS</span>
         </a>
         <!-- Menu: main ul -->

         <ul class="menu-list flex-grow-1 mt-3" id="menu-list">

             <li>
                 <a class="m-link <?= ($currentPage === 'home') ? 'active' : '' ?>" href="index.php?page=home">
                     <i class="icofont-home fs-5"></i>
                     <span>Dashboard</span>
                 </a>
             </li>

             <li class="collapsed">
                 <a class="m-link <?= ($currentPage === 'land' || $currentPage === 'building' || $currentPage === 'machineries') ? 'active' : '' ?>" data-bs-toggle="collapse" data-bs-target="#dashboard-Components" href="#">
                     <i class="icofont-map fs-5"></i> <span>Property</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                 <!-- Menu: Sub menu ul -->
                 <ul class="sub-menu collapse  <?= ($currentPage === 'land' || $currentPage === 'building' || $currentPage === 'machineries') ? 'show' : '' ?>" id="dashboard-Components">
                     <li><a class="ms-link <?= ($currentPage === 'land') ? 'active' : '' ?>" href="index.php?page=land"> <span>Land</span></a></li>
                     <li><a class="ms-link <?= ($currentPage === 'building') ? 'active' : '' ?>" href="index.php?page=building"> <span>Building</span></a></li>
                     <li><a class="ms-link <?= ($currentPage === 'machineries') ? 'active' : '' ?>" href="index.php?page=machineries"> <span>Machineries</span></a></li>
                 </ul>
             </li>

             <!-- <li>
                 <a class="m-link <?= ($currentPage === 'building') ? 'active' : '' ?>" href="index.php?page=building">
                     <i class="icofont-home fs-5"></i>
                     <span>Building</span>
                 </a>
             </li> -->

             <li>
                 <a class="m-link <?= ($currentPage === 'pending') ? 'active' : '' ?>" href="index.php?page=pending">
                     <i class="icofont-search-document fs-5"></i>
                     <span>Pending</span>
                 </a>
             </li>

             <li>
                 <a class="m-link <?= ($currentPage === 'completed') ? 'active' : '' ?>" href="index.php?page=completed">
                     <i class="icofont-document-folder fs-5"></i>
                     <span>Completed</span>
                 </a>
             </li>

             <li>
                 <a class="m-link <?= ($currentPage === 'history') ? 'active' : '' ?>" href="index.php?page=history">
                     <i class="icofont-history fs-5"></i>
                     <span>History</span>
                 </a>
             </li>

             <li>
                 <a class="m-link <?= ($currentPage === 'reports') ? 'active' : '' ?>" href="index.php?page=reports">
                     <i class="icofont-file-text fs-5"></i>
                     <span>Reports</span>
                 </a>
             </li>

             <li>
                 <a class="m-link <?= ($currentPage === 'database') ? 'active' : '' ?>" href="index.php?page=database">
                     <i class="icofont-database fs-5"></i>
                     <span>Database</span>
                 </a>
             </li>

             <li>
                 <a class="m-link <?= ($currentPage === 'user-accounts') ? 'active' : '' ?>" href="index.php?page=user-accounts">
                     <i class="icofont-users-alt-2 fs-5"></i>
                     <span>User</span>
                 </a>
             </li>

             <li>
                 <a class="m-link <?= ($currentPage === 'user-profile') ? 'active' : '' ?>" href="index.php?page=user-profile">
                     <i class="icofont-user-male fs-5"></i>
                     <span>Account</span>
                 </a>
             </li>

         </ul>


         <!-- Theme: Switch Theme -->
         <!-- <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center justify-content-center">
                        <div class="form-check form-switch theme-switch">
                            <input class="form-check-input" type="checkbox" id="theme-switch">
                            <label class="form-check-label" for="theme-switch">Enable Dark Mode!</label>
                        </div>
                    </li>
                    <li class="d-flex align-items-center justify-content-center">
                        <div class="form-check form-switch theme-rtl">
                            <input class="form-check-input" type="checkbox" id="theme-rtl">
                            <label class="form-check-label" for="theme-rtl">Enable RTL Mode!</label>
                        </div>
                    </li>
                </ul> -->

         <!-- Menu: menu collepce btn -->
         <button type="button" class="btn btn-link sidebar-mini-btn text-light">
             <span class="ms-2"><i class="icofont-bubble-right"></i></span>
         </button>
     </div>
 </div>

 <script>
     // $(document).ready(function() {
     //     var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home'; ?>';
     //     var $sidebarLinks = $('#menu-list a');

     //     // Add 'active' class to the active link and remove 'collapsed'
     //     $sidebarLinks.filter('[href="index.php?page=' + page + '"]').addClass('active').removeClass('collapsed');

     //     // Handle click event on sidebar links
     //     $sidebarLinks.click(function() {
     //         var $clickedLink = $(this);

     //         // Remove 'active' class from all links
     //         $sidebarLinks.removeClass('active');
     //         // Add 'active' class to the clicked link
     //         $clickedLink.addClass('active');
     //         // Remove 'collapsed' class from all links
     //         $sidebarLinks.removeClass('collapsed');
     //         // Add 'collapsed' class to all links except the clicked one
     //         $sidebarLinks.not($clickedLink).addClass('collapsed');
     //     });
     // });
 </script>