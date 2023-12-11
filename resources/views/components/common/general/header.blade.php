<header class="bg-white">
    <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-18 items-center justify-between">
        <div class="md:flex md:items-center md:gap-12">
          <a class="block text-teal-600" href="/">
            <img class="w-24 ltr:-ml-1 rtl:-mr-1 inline" src="{{ settings('logo') ? showImage(VIEW_IMAGE_PATH,settings('logo')) : asset('assets/images/logo.png')  }}"
                        alt="" />
          </a>
        </div>
  
        <div class="hidden md:block">
          <nav aria-label="Global">
            
            <ul class="flex items-center gap-6 text-sm">
              @if(request()->route()->getName() == 'home')
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="#home"
                >
                  {{ __('Home') }}
                </a>
              </li>
  
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="#about"
                >
                  {{ __('About Us') }}
                </a>
              </li>
  
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="#services"
                >
                  {{ __('Services') }}
                </a>
              </li>
  
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="#team"
                >
                  {{ __('Team') }}
                </a>
              </li>
  
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="#job"
                >
                  {{ __('Jobs') }}
                </a>
              </li>
  
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="#contact"
                >
                  {{ __('Contact Us') }}
                </a>
              </li>
              @else
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="{{ route('home') }}"
                >
                  {{ __('Home') }}
                </a>
              </li>
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="{{ route('home') }}#about"
                >
                  {{ __('About Us') }}
                </a>
              </li>
  
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="{{ route('service') }}"
                >
                  {{ __('Services') }}
                </a>
              </li>
  
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="{{ route('team') }}"
                >
                  {{ __('Team') }}
                </a>
              </li>
  
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="{{ route('jobs') }}"
                >
                  {{ __('Jobs') }}
                </a>
              </li>
  
              <li>
                <a
                  class="text-gray-500 transition hover:text-gray-500/75"
                  href="{{ route('home') }}#contact"
                >
                  {{ __('Contact Us') }}
                </a>
              </li>
              @endif
            </ul>
          </nav>
        </div>
  
        <div class="flex items-center gap-4">
          <div class="sm:flex sm:gap-4">
            
  
            <div class="hidden sm:flex">
              
            </div>
          </div>
  
          <div class="block md:hidden">
            <button
              class="rounded bg-gray-100 p-2 text-gray-600 transition hover:text-gray-600/75"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </header>
  