    <!-- START: HEADER -->
    <header class="{{\Route::current()->getName() == 'index' ? 'absolute' : ''}} w-full z-50 px-4">
        <div class="container mx-auto py-5">
          <div class="flex flex-stretch items-center">
            <div class="w-56 items-center flex">
              <a href="{{route('index')}}">
                <img
                src="{{url('frontend/images/content/logo.png')}}"
                alt="Luxspace | Fulfill your house with beautiful furniture"
                />
              </a>
            </div>
            <div class="w-full"></div>
            <div class="w-auto">
              <ul
                class="fixed bg-white inset-0 flex flex-col invisible items-center justify-center opacity-0 md:visible md:flex-row md:bg-transparent md:relative md:opacity-100 md:flex md:items-center"
                id="menu"
              >
                <li class="mx-3 py-6 md:py-0">
                  <a href="#" class="text-black {{\Route::current()->getName() == 'index' ? 'md:text-white' : 'md:text-black'}} hover:underline"
                  >Showcase</a
                  >
                </li>
                <li class="mx-3 py-6 md:py-0">
                  <a href="#" class="text-black {{\Route::current()->getName() == 'index' ? 'md:text-white' : 'md:text-black'}} hover:underline"
                    >Catalog</a
                  >
                </li>
                <li class="mx-3 py-6 md:py-0">
                  <a href="#" class="text-black {{\Route::current()->getName() == 'index' ? 'md:text-white' : 'md:text-black'}} hover:underline"
                    >Delivery</a
                  >
                </li>
                <li class="mx-3 py-6 md:py-0">
                  <a href="#" class="text-black {{\Route::current()->getName() == 'index' ? 'md:text-white' : 'md:text-black'}} hover:underline"
                    >Rewards</a
                  >
                </li>
                @auth
                <li class="mx-3 py-6 md:py-0">
                  <a href="{{route('dashboard.index')}}" class="text-black {{\Route::current()->getName() == 'index' ? 'md:text-white' : 'md:text-black'}} hover:underline"
                    >Dashboard</a
                  >
                </li>
                @endauth
                @guest
                <li class="mx-3 py-6 md:py-0">
                  <a href="{{route('login')}}" class="text-black {{\Route::current()->getName() == 'index' ? 'md:text-white' : 'md:text-black'}} hover:underline">
                    Login
                  </a>
                </li>
                <li class="mx-3 py-6 md:py-0">
                  <a href="{{route('register')}}" class="text-black {{\Route::current()->getName() == 'index' ? 'md:text-white' : 'md:text-black'}} hover:underline">
                    Register
                  </a>
                </li>
                @endguest
              </ul>
            </div>
            <div class="w-auto">
              <ul class="items-center flex">
                <li class="ml-6 block md:hidden">
                  <button
                    id="menu-toggler"
                    class="relative flex z-50 items-center justify-center w-8 h-8 text-black {{\Route::current()->getName() == 'index' ? 'md:text-white' : 'md:text-black'}} focus:outline-none"
                  >
                    <svg
                      class="fill-current"
                      width="18"
                      height="17"
                      viewBox="0 0 18 17"
                    >
                      <path
                        d="M15.9773 0.461304H1.04219C0.466585 0.461304 0 0.790267 0 1.19609C0 1.60192 0.466668 1.93088 1.04219 1.93088H15.9773C16.5529 1.93088 17.0195 1.60192 17.0195 1.19609C17.0195 0.790208 16.5529 0.461304 15.9773 0.461304Z"
                      />
                      <path
                        d="M15.9773 7.68802H1.04219C0.466585 7.68802 0 8.01698 0 8.42281C0 8.82864 0.466668 9.1576 1.04219 9.1576H15.9773C16.5529 9.1576 17.0195 8.82864 17.0195 8.42281C17.0195 8.01692 16.5529 7.68802 15.9773 7.68802Z"
                      />
                      <path
                        d="M15.9773 14.9147H1.04219C0.466585 14.9147 0 15.2437 0 15.6495C0 16.0553 0.466668 16.3843 1.04219 16.3843H15.9773C16.5529 16.3843 17.0195 16.0553 17.0195 15.6495C17.0195 15.2436 16.5529 14.9147 15.9773 14.9147Z"
                      />
                    </svg>
                  </button>
                </li>
                <li class="ml-6">
                  <a
                    id="header-cart"
                    class="flex items-center justify-center w-8 h-8 text-black {{\Route::current()->getName() == 'index' ? 'md:text-white' : 'md:text-black'}}"
                    href="{{route('cart')}}"
                  >
                    <svg
                      class="fill-current"
                      width="26"
                      height="24"
                      viewBox="0 0 26 24"
                    >
                      <path
                        d="M10.8754 18.7312C9.61762 18.7312 8.59436 19.7115 8.59436 20.9164C8.59436 22.1214 9.61762 23.1017 10.8754 23.1017C12.1331 23.1017 13.1564 22.1214 13.1564 20.9164C13.1563 19.7115 12.1331 18.7312 10.8754 18.7312ZM10.8754 21.8814C10.3199 21.8814 9.86796 21.4485 9.86796 20.9163C9.86796 20.3842 10.3199 19.9512 10.8754 19.9512C11.4308 19.9512 11.8828 20.3842 11.8828 20.9163C11.8828 21.4486 11.4308 21.8814 10.8754 21.8814Z"
                      />
                      <path
                        d="M18.8764 18.7312C17.6186 18.7312 16.5953 19.7115 16.5953 20.9164C16.5953 22.1214 17.6186 23.1017 18.8764 23.1017C20.1342 23.1017 21.1575 22.1214 21.1575 20.9164C21.1574 19.7115 20.1341 18.7312 18.8764 18.7312ZM18.8764 21.8814C18.3209 21.8814 17.869 21.4485 17.869 20.9163C17.869 20.3842 18.3209 19.9512 18.8764 19.9512C19.4319 19.9512 19.8838 20.3842 19.8838 20.9163C19.8838 21.4486 19.4319 21.8814 18.8764 21.8814Z"
                      />
                      <path
                        d="M19.438 7.2262H10.3122C9.96051 7.2262 9.67542 7.49932 9.67542 7.83626C9.67542 8.1732 9.96056 8.44632 10.3122 8.44632H19.438C19.7897 8.44632 20.0748 8.1732 20.0748 7.83626C20.0748 7.49927 19.7897 7.2262 19.438 7.2262Z"
                      />
                      <path
                        d="M18.9414 10.3942H10.8089C10.4572 10.3942 10.1721 10.6673 10.1721 11.0042C10.1721 11.3412 10.4572 11.6143 10.8089 11.6143H18.9413C19.293 11.6143 19.5781 11.3412 19.5781 11.0042C19.5781 10.6673 19.293 10.3942 18.9414 10.3942Z"
                      />
                      <path
                        d="M25.6499 4.508C25.407 4.22245 25.0472 4.05871 24.6626 4.05871H4.82655L4.42595 2.19571C4.34232 1.80709 4.06563 1.48078 3.68565 1.32272L0.890528 0.160438C0.567841 0.0261566 0.192825 0.168008 0.0528584 0.477043C-0.0872597 0.786176 0.0608116 1.14549 0.383347 1.27957L3.17852 2.4419L6.2598 16.7708C6.38117 17.3351 6.90578 17.7446 7.50723 17.7446H22.7635C23.1152 17.7446 23.4003 17.4715 23.4003 17.1346C23.4003 16.7976 23.1152 16.5245 22.7635 16.5245H7.50728L7.13247 14.7815H22.8814C23.4828 14.7815 24.0075 14.3719 24.1288 13.8076L25.9101 5.52488C25.9876 5.16421 25.8928 4.79349 25.6499 4.508ZM22.8814 13.5615H6.87012L5.08895 5.27879L24.6626 5.27884L22.8814 13.5615Z"
                      />
                    </svg>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </header>
  
      <!-- END: HEADER -->