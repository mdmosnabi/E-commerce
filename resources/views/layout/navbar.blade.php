<nav class="bg-white border-gray-200 px-4 py-2.5 rounded dark:bg-gray-900">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
        <a href="/" class="flex items-center">
            <img src="{{ asset('logo.png') }}" class="h-6 mr-3 sm:h-9" alt="Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">My Shop</span>
        </a>

        <div class="w-full md:block md:w-auto" id="navbar-default">
            <ul
                class="flex flex-wrap p-4 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <!-- searching field -->
                <li class="relative">
                    <form action="/search" method="GET" class="block">
                        <input type="text" name="query" placeholder="Search products..."
                            class="w-full py-2 pl-3 pr-8 text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 md:w-auto dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6a8 8 0 100 16 8 8 0 000-16zM21 21l-4.35-4.35"/>
                            </svg>
                        </button>
                    </form>
                </li>

                <li class="relative">
                    <a href="javascript:void(0);" id="categoryMenuButton"
                        class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Category
                    </a>
                    <!-- Dropdown Menu -->
                    <ul id="categoryDropdownMenu"
                        class="absolute left-0 hidden mt-2 space-y-2 bg-white border border-gray-100 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700">
                        <li>
                            <a href="/category/1"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"> Food
                                </a>
                        </li>
                        <li>
                            <a href="/category/2"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Toy
                                </a>
                        </li>
                        <li>
                            <a href="/category/3"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Motor Cycle
                                </a>
                        </li>
                        <!-- Add more categories as needed -->
                    </ul>
                </li>

                <li>
                    <div onclick="cartList()" id="cartContain" class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Cart
                    </div>
                </li>

                <li>
                    <a href="/contact"
                        class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Contact</a>
                </li>

                <li>
                    <a href="/account"
                        class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Account</a>
                </li>
            </ul>

        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const categoryMenuButton = document.getElementById("categoryMenuButton");
        const categoryDropdownMenu = document.getElementById("categoryDropdownMenu");
    
        categoryMenuButton.addEventListener("click", function() {
            // Toggle the visibility of the dropdown menu
            if (categoryDropdownMenu.classList.contains("hidden")) {
                categoryDropdownMenu.classList.remove("hidden");
            } else {
                categoryDropdownMenu.classList.add("hidden");
            }
        });
    
        // Close the dropdown if clicked outside
        document.addEventListener("click", function(event) {
            if (!categoryMenuButton.contains(event.target) && !categoryDropdownMenu.contains(event
                .target)) {
                categoryDropdownMenu.classList.add("hidden");
            }
        });
    });
    </script>
</nav>