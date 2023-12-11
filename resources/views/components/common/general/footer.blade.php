<!-- Start Footer -->
<footer class="py-8 bg-slate-800 dark:bg-gray-900">
    <div class="container">
        <div class="grid md:grid-cols-12 items-center">
            <div class="md:col-span-3">
                <a href="#" class="logo-footer">
                    <img src="assets/images/logo-light.png" class="md:ml-0 mx-auto" alt="">
                </a>
            </div>

            <div class="md:col-span-6 md:mt-0 mt-8">
                <div class="text-center">
                    <p class="text-gray-400">© <script>document.write(new Date().getFullYear())</script>
                        @if(!empty(settings()['copyright_text']))
                            {{ settings()['copyright_text'] }}
                        @else    
                         All right reserved <i class="mdi mdi-heart text-orange-700"></i> by <a href="" class="text-reset">{{ $settings['app_title'] }}</a>
                        @endif 
                        </p>
                </div>
            </div>

            <div class="md:col-span-3 md:mt-0 mt-8">
                
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->
</footer><!--end footer-->
<!-- End Footer -->