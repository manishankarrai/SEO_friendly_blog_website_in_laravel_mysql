       <!-- End Page-content -->

       <footer class="footer border-top">
           <div class="container-fluid">
               <div class="row">
                   <div class="col-sm-6">
                       ©
                       <script>
                           document.write(new Date().getFullYear())

                       </script> myblog .
                   </div>
                   <div class="col-sm-6">
                       <div class="text-sm-end d-none d-sm-block">

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
       {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
       <script src="{{ url('public/assets/js/jquery.min.js') }}"></script>
       <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
       <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
       <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
       <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
       <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
       <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
       <script src="{{ url('public/assets/js/pages/datatables.init.js') }}"></script>

       <script src="https://cdn.tiny.cloud/tinymce.min.js" referrerpolicy="origin"></script>
       {{-- add your tinney editor link here  --}}
       <script>
           tinymce.init({
               selector: '.mytextarea'
               , plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount'
               , toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat'
           , });

       </script>

       <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
       <script>
           ClassicEditor
               .create(document.querySelector('#myeditor'), {

                   removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed']
               , })
               .catch(error => {
                   console.error(error);
               });

       </script>

       <script src="{{ url('public/assets/js/select2/dist/js/select2.min.js') }}"></script>

       <script>
           $(document).ready(function() {

               $(".select2").select2();
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });

               $("#topnav-hamburger-icon").click(function() {
                   $("#mySidepanel").css("width", "250px");
               });

               $(".closebtn").click(function() {
                   $("#mySidepanel").css("width", "0");
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
