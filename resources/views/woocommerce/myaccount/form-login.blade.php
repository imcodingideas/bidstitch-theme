{{--
@see     https://docs.woocommerce.com/document/template-structure/
@author  WooThemes
@package WooCommerce/Templates
@version 4.1.0
--}}
@php
    wc_print_notices();
    do_action( 'woocommerce_before_customer_login_form' );
@endphp
    <div class="flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="rounded border mx-auto mt-4 shadow sm:w-full sm:max-w-md">
            <!-- Tabs -->
            <ul id="tabs" class="flex space-x-2">
              <li class="flex-1 bg-white text-gray-800 font-semibold p-3 text-center rounded-t-mb-px"><a id="login" href="#login" class="block">Login</a></li>
              <li class="flex-1 p-3 text-gray-800 font-semibold text-center rounded-t"><a href="#register" class="block">Register</a></li>
            </ul>
          
            <!-- Tab Contents -->
            <div id="tab-contents" class="bg-white py-8 px-4 sm:px-10">
              <div id="login" class="p-4">
                <h3 class="mt-3 text-center text-2xl font-extrabold text-gray-900">Sign in to your account</h3>
                <div class="mt-8">
                    <form class="space-y-6 mb-4" method="post">
                        @php(do_action( 'woocommerce_login_form_start' ))
                        <div class="form-group">
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">{{ __( 'Username or email', 'woocommerce' ) }} <sup>*</sup></label>
                            <input type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm" name="username" id="username"
                                value="{{ ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''}}"/>
                        </div>
                        <div class="form-group">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __( 'Password', 'woocommerce' ) }} <sup>*</sup></label>
                            <input class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm" type="password" name="password" id="password"/>
                        </div>
    
                        @php(do_action( 'woocommerce_login_form' ))
                            {!! wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ) !!}
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                        name="rememberme"
                                        type="checkbox"
                                        id="rememberme" value="forever"/>
                                    <label class="ml-2 block text-sm text-gray-900">
                                        {{  __( 'Remember me', 'woocommerce' ) }}
                                    </label>
                                </div>
                                <div class="text-sm">
                                    <a href="{{ esc_url( wp_lostpassword_url() ) }}" class="font-medium text-black hover:text-black">{{  __( 'Lost your password?', 'woocommerce' ) }}</a>
                                </div>
                            </div>
                        @php(do_action( 'woocommerce_login_form_end' ))
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black" name="login" value="@php(esc_attr_e( 'Login', 'woocommerce' ))">{{ __( 'Login', 'woocommerce' ) }}</button>
                    </form>
                </div>
              </div>
              <div id="register" class="hidden p-4">
                <h3 class="mt-3 text-center text-2xl font-extrabold text-gray-900">Register for an account</h3>
                <div class="mt-8">
                    <form method="post" class="space-y-6 mb-4">
                        @php(do_action( 'woocommerce_register_form_start' ))
        
                        @if('no' === get_option( 'woocommerce_registration_generate_username' ) ))
                        <div class="form-group">
                            <label for="reg_username">{{ __( 'Username', 'woocommerce' ) }}<span
                                        class="required block text-sm font-medium text-gray-700 mb-2">*</span></label>
                            <input type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm" name="username"
                                   id="reg_username"
                                   value="{{ ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : '' }}"/>
                        </div>
                        @endif
        
                        <div class="form-group">
                            <label for="reg_email" class="block text-sm font-medium text-gray-700 mb-2">{{ __( 'Email address', 'woocommerce' ) }}<sup>*</sup></label>
                            <input type="email" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm" name="email"
                                   id="reg_email"
                                   value="{{ ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : '' }}"/>
                        </div>
        
                        @if( 'no' === get_option( 'woocommerce_registration_generate_password' ) )
                            <div class="form-group">
                                <label for="reg_password" class="block text-sm font-medium text-gray-700 mb-2">{{ __( 'Password', 'woocommerce' ) }}<sup>*</sup></label>
                                <input type="password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black sm:text-sm"
                                       name="password" id="reg_password"/>
                            </div>
                        @endif
        
                        @php(do_action( 'woocommerce_register_form' ))
                        <div class="form-group">
                            @php(wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ))
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black" name="register"
                                    value="@php(esc_attr_e( 'Register', 'woocommerce' ))">{{ __( 'Register', 'woocommerce' ) }}</button>
                        </div>
                        @php(do_action( 'woocommerce_register_form_end' ))
                    </form>
                    <p class="mt-2 text-center text-md text-gray-600">
                        Want to Sell?
                        <!-- space -->
                        <a href="/vendor-registration" class="font-medium text-black hover:text-black">
                          Register as a vendor here
                        </a>
                      </p>
                </div>
              </div>
            </div>
          </div>
        
    </div>
@php(do_action( 'woocommerce_after_customer_login_form' ))