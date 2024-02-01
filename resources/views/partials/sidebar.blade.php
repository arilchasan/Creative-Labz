<head>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css"> --}}
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
        class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-80 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 font-sans"
        aria-label="Sidebar">
        <div class="h-full px-2 py-4 overflow-y-auto bg-gray-900">
            <a href="" class="flex items-center justify-center mb-5">
                <img src="/assets/logo.png" class="h-6 mr-2 sm:h-7" alt="Logo" />
                <span class="self-center text-xl font-semibold whitespace-nowrap text-white dark:text-white">Creativ
                    Labz</span>
            </a>
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="/dashboard/home"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/admin/all"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white"
                            xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                            <path fill="#ffffff"
                                d="M96 128a128 128 0 1 0 256 0A128 128 0 1 0 96 128zm94.5 200.2l18.6 31L175.8 483.1l-36-146.9c-2-8.1-9.8-13.4-17.9-11.3C51.9 342.4 0 405.8 0 481.3c0 17 13.8 30.7 30.7 30.7H162.5c0 0 0 0 .1 0H168 280h5.5c0 0 0 0 .1 0H417.3c17 0 30.7-13.8 30.7-30.7c0-75.5-51.9-138.9-121.9-156.4c-8.1-2-15.9 3.3-17.9 11.3l-36 146.9L238.9 359.2l18.6-31c6.4-10.7-1.3-24.2-13.7-24.2H224 204.3c-12.4 0-20.1 13.6-13.7 24.2z" />
                        </svg>
                        <span class="ml-3">Admin</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/user/all"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>

                        <span class="ml-3">Customer</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/contact/all"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white"
                            xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
                            <path fill="#ffffff"
                                d="M0 96l576 0c0-35.3-28.7-64-64-64H64C28.7 32 0 60.7 0 96zm0 32V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128H0zM64 405.3c0-29.5 23.9-53.3 53.3-53.3H234.7c29.5 0 53.3 23.9 53.3 53.3c0 5.9-4.8 10.7-10.7 10.7H74.7c-5.9 0-10.7-4.8-10.7-10.7zM176 192a64 64 0 1 1 0 128 64 64 0 1 1 0-128zm176 16c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16z" />
                        </svg>
                        <span class="ml-3">Contact</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/news/all"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                        </svg>
                        <span class="ml-3">News</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/promo/all"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white"
                            xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
                            <path fill="#ffffff"
                                d="M64 64C28.7 64 0 92.7 0 128v60.1c0 10.2 6.4 19.2 16 22.6c18.7 6.6 32 24.4 32 45.3s-13.3 38.7-32 45.3c-9.6 3.4-16 12.5-16 22.6V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V323.9c0-10.2-6.4-19.2-16-22.6c-18.7-6.6-32-24.4-32-45.3s13.3-38.7 32-45.3c9.6-3.4 16-12.5 16-22.6V128c0-35.3-28.7-64-64-64H64zM48 128c0-8.8 7.2-16 16-16H512c8.8 0 16 7.2 16 16v44.9c-28.7 16.6-48 47.6-48 83.1s19.3 66.6 48 83.1V384c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V339.1c28.7-16.6 48-47.6 48-83.1s-19.3-66.6-48-83.1V128zM400 304H176V208H400v96zM128 192V320c0 17.7 14.3 32 32 32H416c17.7 0 32-14.3 32-32V192c0-17.7-14.3-32-32-32H160c-17.7 0-32 14.3-32 32z" />
                        </svg>
                        <span class="ml-3">Promo Code</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/product/all"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" data-slot="icon" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        <span class="ml-3">Product</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/cart/all"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" data-slot="icon" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>

                        <span class="ml-3">Cart</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/order/all"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <span class="ml-3">Order</span>
                    </a>
                </li>
                <li>
                    <a href="/dashboard/order/req-order"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="w-5 h-5  transition duration-75 text-white dark:text-white group-hover:text-white dark:group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="#ffffff" d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23L384 112c-13.3 0-24-10.7-24-24s10.7-24 24-24l174.1 0L535 41zM105 377l-23 23L256 400c13.3 0 24 10.7 24 24s-10.7 24-24 24L81.9 448l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64H337.9c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5V384c0 35.3-28.7 64-64 64H302.1c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5V128c0-35.3 28.7-64 64-64zm64 64H96v64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64h64V320zM320 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg>
                        <span class="ml-3">Transfer</span>
                    </a>
                </li>
                <br>
                <br>
                <li>
                    <a href="/logout"
                        class="flex items-center p-2 text-white rounded-lg dark:text-white hover:bg-teal-500 dark:hover:bg-teal-500 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Keluar</span>
                    </a>
                </li>

            </ul>
        </div>
    </aside>


</body>
