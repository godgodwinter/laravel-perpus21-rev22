
        
{{-- @yield('datatable') --}}
{{-- {{ dd($datas) }} --}}      

    <div class="card-body -mt-5">
        <div class="table-responsive">
            <table class="table table-bordered table-md">
                @yield('headtable')
                @yield('bodytable')
            
            </table>
        </div>
        <div class="card-footer text-right">
                @yield('foottable')
        </div>