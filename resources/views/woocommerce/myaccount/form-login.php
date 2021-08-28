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
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="header-logo text-xl lg:text-3xl text-black leading-none text-center tracking-widest">
                <a href="{{ home_url('/') }}">{{ $siteName }}</a>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>

        </div>
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md" id="customer-login">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
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
                <p class="mt-3 text-sm text-center text-gray-600">
                    Don't have an account?
                    <!-- space -->
                    <a href="/register" class="font-medium text-black hover:text-black">
                      Register here
                    </a>
                  </p>
            </div>
        </div>
    </div>
@php(do_action( 'woocommerce_after_customer_login_form' ))
