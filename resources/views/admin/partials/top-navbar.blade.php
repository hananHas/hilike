<div class="app-header header-shadow">
  <div class="app-header__logo">
    <div class="logo-src1" style="text-align: center; width:100%" >
        <img style="width:3rem" src="{{ asset('logo.jpg') }}" alt="">
    </div>
      <div class="header__pane ml-auto">
          <div>
              <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                  <span class="hamburger-box">
                      <span class="hamburger-inner"></span>
                  </span>
              </button>
          </div>
      </div>
  </div>
  <div class="app-header__mobile-menu">
      <div>
          <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
              <span class="hamburger-box">
                  <span class="hamburger-inner"></span>
              </span>
          </button>
      </div>
  </div>
  <div class="app-header__menu">
      <span>
          <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
              <span class="btn-icon-wrapper">
                  <i class="fa fa-ellipsis-v fa-w-6"></i>
              </span>
          </button>
      </span>
  </div>    <div class="app-header__content">
      <div class="app-header-left">
          <div class="search-wrapper">
              <div class="input-holder">
                  <input type="text" class="search-input" placeholder="Type to search">
                  <button class="search-icon"><span></span></button>
              </div>
              <button class="close"></button>
          </div>
        </div>
      <div class="app-header-right">
          <div class="header-dots">
            
              
          </div>
          
          <div class="header-btn-lg pr-0">
              <div class="widget-content p-0">
                  <div class="widget-content-wrapper">
                      <div class="widget-content-left">
                          <div class="btn-group">
                             
                              
                          </div>
                      </div>
                      <div class="widget-content-left  ml-3 header-user-info">
                          <div class="widget-heading">
                              {{Auth::user()->name}}
                          </div>
                          <div class="widget-subheading">
                              Administrator
                          </div>
                      </div>
                      <div class="widget-content-right header-user-info ml-3">
                          {{-- <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm"> --}}
                            <img width="42" class="rounded-circle" src="{{asset('images/avatar_male.jpg')}}" alt="">
                          {{-- </button> --}}
                      </div>
                  </div>
              </div>
          </div>
          <div class="header-btn-lg">
                

                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="nav-link" role="button"><i class="lnr-exit icon-gradient bg-night-fade" style="font-size: 2.5em;"></i></a>  
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>                      
    
    
          </div>        
        </div>
  </div>
</div>

  