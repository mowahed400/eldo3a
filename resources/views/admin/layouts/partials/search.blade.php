<div class="col-lg-4 col-md-4 col-sm-12" >

    <label for="">&nbsp;&nbsp;بحث</label>

    <div class="input-group input-group-merge">
        <input type="text" class="form-control form-control-merge" id="search"
               name="search" value="{{request('search')}}" placeholder="..."
               aria-describedby="search" tabindex="1"/>
        <div class="input-group-append">
            <span class="input-group-text cursor-pointer"
                  onclick="document.getElementById('filter-form').submit()"
                  id="cursor-pointer"><i data-feather="search"></i>
            </span>
        </div>
    </div>
</div>
