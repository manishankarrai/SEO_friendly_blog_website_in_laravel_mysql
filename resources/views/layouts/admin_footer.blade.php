       <!-- End Page-content -->

       <footer class="footer border-top">
           <div class="container-fluid">
               <div class="row">
                   <div class="col-sm-6">
                       <script>
                           document.write(new Date().getFullYear())
                       </script> © Free eBook.
                   </div>
                   <div class="col-sm-6">
                       <div class="text-sm-end d-none d-sm-block">
                           Design & Develop by Books Cloud
                       </div>
                   </div>
               </div>
           </div>
       </footer>
       </div>
       <!-- end main content-->

       </div>
       <!-- END layout-wrapper -->



       <!--start back-to-top-->
       <button onclick="topFunction()" class="btn btn-primary btn-icon" id="back-to-top">
           <i class="ri-arrow-up-line"></i>
       </button>
       <!--end back-to-top-->



       <!-- Theme Settings -->


       <!-- JAVASCRIPT -->
       <script src="{{ url('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
       <script src="{{ url('public/assets/libs/simplebar/simplebar.min.js') }}"></script>
       <script src="{{ url('public/assets/libs/node-waves/waves.min.js') }}"></script>
       <script src="{{ url('public/assets/libs/feather-icons/feather.min.js') }}"></script>
       <script src="{{ url('public/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
       <script src="{{ url('public/assets/js/plugins.js') }}"></script>

       <!-- apexcharts -->
       <script src="{{ url('public/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

       <!-- Vector map-->
       <script src="{{ url('public/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
       <script src="{{ url('public/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

       <!--Swiper slider js-->
       <script src="{{ url('public/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

       <!-- Dashboard init -->
       <script src="{{ url('public/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

       <!-- App js -->
       <script src="{{ url('public/assets/js/app.js') }}"></script>
       <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
       <script src="{{ url('public/assets/js/jquery.min.js') }}"></script>



 <script src="{{ url('public/assets/js/pages/select2.init.js')}}"></script>
       <script>
         $(document).ready(function(){

         $(".select2").select2();
        $.ajaxSetup({
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
          });


    });

       
           function DeleteItems(page, action, id) {
               var where_to = confirm("Do you really want to Delete this??");
               if (where_to == true) {
                   window.location.href = page + "/" + action + "/" + id;
               }
           }
       </script>

        @yield('js_bottom')
       </body>

       </html>
