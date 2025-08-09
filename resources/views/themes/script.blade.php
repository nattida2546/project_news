    <!-- ./wrapper -->
    @yield('script')
     <!-- jQuery -->
     <script src="{{ URL::asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('dist/js/adminlte.min.js')}}"></script>
    <!-- ChartJS -->
    {{-- <script src="{{ URL::asset('plugins/chart.js/Chart.min.js')}}"></script> --}}
    @yield('script')
    @stack('scripts')