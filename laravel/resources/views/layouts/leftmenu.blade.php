@if(Auth::user()->level == 'karyawan')
              <li class="nav-item has-treeview">
                <a href="{{ route('home') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt blue"></i>
                  <p>
                    Dashboard
                   
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="{{ route('user.tamu') }}" class="nav-link">
                  <i class="nav-icon fas fa-clock"></i>
                  <p>
                    Tamu
                  </p>
                </a>
              </li>
              

              @else
              
              <li class="nav-item has-treeview">
                <a href="{{ route('home') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt blue"></i>
                  <p>
                    Dashboard 
                  </p>
                </a>
              </li>
              
              <li class="nav-item has-treeview">
                <a href="{{  route('admin.tamu') }}" class="nav-link">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>
                    Tamu
                    
                  </p>
                </a>
              </li>

              <li class="nav-item has-treeview">
                <a href="{{  route('admin.reporttamu') }}" class="nav-link">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>
                    Report
                    
                  </p>
                </a>
              </li>

              <li class="nav-item has-treeview">
                <a href="{{  route('admin.grafik_reporttamu') }}" class="nav-link">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>
                    Grafik
                    
                  </p>
                </a>
              </li>

              <li class="nav-item has-treeview">
                <a href="{{  route('admin.user') }}" class="nav-link">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>
                    Setting Karyawan
                    
                  </p>
                </a>
              </li>

              @endif
              

              
              

              <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                           
                  <i class="nav-icon fas fa-power-off red"></i>
                  <p>
                    {{ __('Logout') }} 
                    
                  </p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                
              </li>
              
              
