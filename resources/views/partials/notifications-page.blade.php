<div class="notifications-page">
  <h1 class="font-bold md:text-3xl md:text-left mx-2 text-center text-lg uppercase">Notifications</h1>
  <div x-data="notificationsPageData()">

    <div x-show="isLoading">
      <img class="w-8 m-12" src="@asset('images/loading.gif')" alt="spinner" />
    </div>

    <div x-show="!isLoading" v-cloak>

      <h2 x-show="notifications.length == 0" class="font-bold md:text-xl md:text-left mx-2 text-center text-lg uppercase mt-6 md:mt-12">There's no notifications at the moment</h2>

      <div x-show="notifications.length > 0">

        <div class="bg-white shadow overflow-hidden sm:rounded-md mt-6 md:mt-12">
          <ul role="list" class="divide-y divide-gray-200">

            <template x-for="notification in notifications">
              <li>
                <div class="px-4 py-4 sm:px-6">
                  <div class="flex flex-col items-center md:flex-row md:justify-start md:space-x-6 md:space-y-0 space-y-3 w-100 xl:space-x-12">
                    <p class="text-md text-gray-400 font-black uppercase md:text-sm">
                      <span x-text="notification.date"></span>
                      <span x-text="notification.time"></span>
                    </p>

                    <div class="flex items-center md:w-1/2 space-x-4">
                      <a :href="notification.link">
                        <img class="h-12 w-auto" :src="notification.thumbnail" alt="thumbnail" />
                      </a>
                      <a :href="notification.link">
                        <p class="font-medium text-gray-700" x-text="notification.text"></p>
                      </a>
                    </div>

                    <div class="relative flex flex-1 flex-col items-center justify-center md:flex-row md:justify-end md:space-y-0 space-x-4 space-y-2">
                      <div class="absolute bg-white top-0 bottom-0 left-0 right-0 z-10" x-show="notification.isLoading">
                        <img class="w-4 mx-auto" src="@asset('images/loading.gif')" alt="spinner" />
                      </div>
                      <p class="font-medium md:text-md text-indigo-600 text-lg" x-text="notification.title"></p>
                    </div>

                  </div>
                </div>
              </li>
            </template>

          </ul>
        </div>

        <div class="text-center lg:text-left">
          <button x-show="page < pages" x-on:click="loadMore()" class="btn btn--black btn--md mt-12">
            Load More
            <img x-show="loadMoreLoading" class="w-4 ml-2" src="@asset('images/loading.gif')" alt="spinner" />
          </button>
        </div>

      </div>

    </div>

  </div>

</div>
