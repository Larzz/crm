@extends('administrator.layouts.default')

@section('content')
 
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    @include('administrator.includes.top_nav')
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-12 col-7">
              <ul class="nav-sub-sx">
                <li> <a href="">Blog</a> </li>
                <li> <a href="">Presentations</a> </li>
                <li> <a href="">Client Backend</a> </li>
                <li> <a href="">Website</a> </li>
                <li> <a href="">Newsletter</a> </li>
                <li> <a href="">Tutorials</a> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-6">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h4 class="h3 mb-0">Bulettin</h4>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="bulettin-container">
              <h4>Saturday Schedule</h4>
              <p> 
                Dear All,
                Please compile the satuday schedule Please compile the satuday schedule Please compile the satuday schedule
                Please compile the satuday schedule Please compile the satuday schedule Please compile the satuday schedule
                Please compile the satuday schedule Please compile the satuday schedule Please compile the satuday schedule
                Please compile the satuday schedule Please compile the satuday schedule Please compile the satuday schedule
                Please compile the satuday schedule Please compile the satuday schedule Please compile the satuday schedule
              </p> 
            </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Performance</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
                  <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="">Message</label>
                    <textarea name="" id="" cols="30" rows="5" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="">Active</label>
                    <select name="" id="" class="form-control">
                      <option value="" class="form-control">Yes</option>
                      <option value="" class="form-control">No</option>
                    </select>
                  </div>
                      <button href="#!" class="btn btn-primary">Add</button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-8">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Leave Application</h3>
                </div>
                <div class="col text-right">
                  <a href="#!" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Leave From</th>
                    <th scope="col">Leave To</th>
                    <th scope="col">Days</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">
                      /argon/profile.html
                    </th>
                    <td>
                      1,795
                    </td>
                    <td>
                      190
                    </td>
                    <td>
                      <i class="fas fa-arrow-down text-danger mr-3"></i> 46,53%
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Employees</h3>
                </div>
                <div class="col text-right">
                  <a href="#!" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                
                <tbody>
                 
                  <tr>
                    <th scope="row">
                      twitter
                    </th>
                    <td>
                      2,645
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <span class="mr-2">30%</span>
                        <div>
                          <div class="progress">
                            <div class="progress-bar bg-gradient-warning" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%;"></div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Client list</h3>
                </div>
                <div class="col text-right">
                  <a href="#!" class="btn btn-sm btn-primary">See all</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                
                <tbody>
                 
                  <tr>
                    <th scope="row">
                      twitter
                    </th>
                    <td>
                      2,645
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <span class="mr-2">30%</span>
                        <div>
                          <div class="progress">
                            <div class="progress-bar bg-gradient-warning" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%;"></div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-xl-12">
          
        </div>
      </div>
      <!-- Footer -->
      @include('administrator.includes.footer')
    </div>
  </div>

@endsection