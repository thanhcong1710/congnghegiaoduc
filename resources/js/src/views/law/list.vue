<!-- =========================================================================================
  File Name: ECommerceShop.vue
  Description: eCommerce Shop Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div>
        <div class="ais-InstantSearch" id="algolia-instant-search-demo">

            <!-- AIS CONFIG -->

            <div class="algolia-header mb-4">
                <div class="flex md:items-end items-center justify-between flex-wrap">
                    <!-- TOGGLE SIDEBAR BUTTON -->
                    <feather-icon
                        class="inline-flex lg:hidden cursor-pointer mr-4"
                        icon="MenuIcon"
                        @click.stop="toggleFilterSidebar" />

                    <p class="lg:inline-flex hidden font-semibold algolia-filters-label">Filters</p>

                    <div class="flex justify-between items-end flex-grow">
                        <div class="ais-Stats"></div>

                        <div class="flex flex-wrap">

                            <!-- ITEM VIEW - GRID/LIST -->
                            <div>
                                <feather-icon
                                    icon="GridIcon"
                                    @click="currentItemView='item-grid-view'"
                                    class="p-2 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer"
                                    :svgClasses="{'text-primary stroke-current': currentItemView == 'item-grid-view'}" />
                                <feather-icon
                                    icon="ListIcon"
                                    @click="currentItemView='item-list-view'"
                                    class="p-2 ml-4 shadow-drop rounded-lg d-theme-dark-bg cursor-pointer hidden sm:inline-flex"
                                    :svgClasses="{'text-primary stroke-current': currentItemView == 'item-list-view'}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="algolia-content-container" class="relative clearfix">
                <vs-sidebar
                    class="items-no-padding vs-sidebar-rounded background-absolute"
                    parent="#algolia-content-container"
                    :click-not-close="clickNotClose"
                    :hidden-background="clickNotClose"
                    v-model="isFilterSidebarActive">

                    <div class="p-6 filter-container">
                      <h6 class="font-bold mb-3">Tỉnh/Thành Phố</h6>
                      <div class="multi-range-price">
                        <ul class="list-unstyled price-range" id="price-range">
                            <li class="flex items-center cursor-pointer py-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="priceAll" name="price-range" class="custom-control-input" checked />
                                    <label class="custom-control-label" for="priceAll">Tất cả</label>
                                </div>
                            </li>
                            <li class="flex items-center cursor-pointer py-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="priceRange1" name="price-range" class="custom-control-input" />
                                    <label class="custom-control-label" for="priceRange1">Hà Nội</label>
                                </div>
                            </li>
                            <li class="flex items-center cursor-pointer py-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="priceRange2" name="price-range" class="custom-control-input" />
                                    <label class="custom-control-label" for="priceRange2">Hồ Chí Minh</label>
                                </div>
                            </li>
                            <li class="flex items-center cursor-pointer py-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="priceARange3" name="price-range" class="custom-control-input" />
                                    <label class="custom-control-label" for="priceARange3">Đà Nẵng</label>
                                </div>
                            </li>
                            <li class="flex items-center cursor-pointer py-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="priceRange4" name="price-range" class="custom-control-input" />
                                    <label class="custom-control-label" for="priceRange4">Hải Phòng</label>
                                </div>
                            </li>
                            <li class="flex items-center cursor-pointer py-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="priceRange4" name="price-range" class="custom-control-input" />
                                    <label class="custom-control-label" for="priceRange4">Thái Nguyên</label>
                                </div>
                            </li>
                            <li class="flex items-center cursor-pointer py-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="priceRange4" name="price-range" class="custom-control-input" />
                                    <label class="custom-control-label" for="priceRange4">Nghệ An</label>
                                </div>
                            </li>
                            <li class="flex items-center cursor-pointer py-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="priceRange4" name="price-range" class="custom-control-input" />
                                    <label class="custom-control-label" for="priceRange4">Phú Thọ</label>
                                </div>
                            </li>
                        </ul>
                      </div>
                      <vs-divider />
                      <h6 class="font-bold mb-3">Lĩnh Vực</h6>
                      <div class="ais-RefinementList">
                        <div>
                            <ul>
                                <!---->
                                <li class="mb-2 flex items-center justify-between">
                                    <div class="vs-component con-vs-checkbox ml-0 vs-checkbox-primary vs-checkbox-default"><input
                                            type="checkbox" class="vs-checkbox--input" value="false"><span class="checkbox_x vs-checkbox"
                                            style="border: 2px solid rgb(180, 180, 180);"><span class="vs-checkbox--check"><i
                                                    class="vs-icon notranslate icon-scale vs-checkbox--icon  material-icons null">check</i></span></span><span
                                            class="con-slot-label">Tất cả</span></div> <span>1746</span>
                                </li>
                                <li class="mb-2 flex items-center justify-between">
                                    <div class="vs-component con-vs-checkbox ml-0 vs-checkbox-primary vs-checkbox-default"><input
                                            type="checkbox" class="vs-checkbox--input" value="false"><span class="checkbox_x vs-checkbox"
                                            style="border: 2px solid rgb(180, 180, 180);"><span class="vs-checkbox--check"><i
                                                    class="vs-icon notranslate icon-scale vs-checkbox--icon  material-icons null">check</i></span></span><span
                                            class="con-slot-label">Đất đai</span></div> <span>746</span>
                                </li>
                                <li class="mb-2 flex items-center justify-between">
                                    <div class="vs-component con-vs-checkbox ml-0 vs-checkbox-primary vs-checkbox-default"><input
                                            type="checkbox" class="vs-checkbox--input" value="false"><span class="checkbox_x vs-checkbox"
                                            style="border: 2px solid rgb(180, 180, 180);"><span class="vs-checkbox--check"><i
                                                    class="vs-icon notranslate icon-scale vs-checkbox--icon  material-icons null">check</i></span></span><span
                                            class="con-slot-label">Bảo hiểm</span></div> <span>633</span>
                                </li>
                                <li class="mb-2 flex items-center justify-between">
                                    <div class="vs-component con-vs-checkbox ml-0 vs-checkbox-primary vs-checkbox-default"><input
                                            type="checkbox" class="vs-checkbox--input" value="false"><span class="checkbox_x vs-checkbox"
                                            style="border: 2px solid rgb(180, 180, 180);"><span class="vs-checkbox--check"><i
                                                    class="vs-icon notranslate icon-scale vs-checkbox--icon  material-icons null">check</i></span></span><span
                                            class="con-slot-label">Doanh nghiệp</span></div> <span>591</span>
                                </li>
                                 <li class="mb-2 flex items-center justify-between">
                                    <div class="vs-component con-vs-checkbox ml-0 vs-checkbox-primary vs-checkbox-default"><input
                                            type="checkbox" class="vs-checkbox--input" value="false"><span class="checkbox_x vs-checkbox"
                                            style="border: 2px solid rgb(180, 180, 180);"><span class="vs-checkbox--check"><i
                                                    class="vs-icon notranslate icon-scale vs-checkbox--icon  material-icons null">check</i></span></span><span
                                            class="con-slot-label">Hình sự</span></div> <span>523</span>
                                </li>
                                <li class="mb-2 flex items-center justify-between">
                                    <div class="vs-component con-vs-checkbox ml-0 vs-checkbox-primary vs-checkbox-default"><input
                                            type="checkbox" class="vs-checkbox--input" value="false"><span class="checkbox_x vs-checkbox"
                                            style="border: 2px solid rgb(180, 180, 180);"><span class="vs-checkbox--check"><i
                                                    class="vs-icon notranslate icon-scale vs-checkbox--icon  material-icons null">check</i></span></span><span
                                            class="con-slot-label">Hôn nhân gia đình</span></div> <span>625</span>
                                </li>
                            </ul>
                        </div>
                        <vs-divider />
                        <h6 class="font-bold mb-3">Đánh giá</h6>
                        <div attribute="rating">
                            <ul>
                                <li v-for="item in itemsRate" :key="item" class="mb-2">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center flex-wrap">
                                            <feather-icon icon="StarIcon" :svgClasses="[{'text-warning': index<=item, 'text-grey': !index<=item, 'ml-1' : index}, 'cursor-pointer stroke-current h-6 w-6']" v-for="index in [1,2,3,4,5]" :key="index" />
                                            <span class="ml-2">&amp; up</span>
                                        </div>
                                        <span>(200)</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                      </div>
                    </div>
                </vs-sidebar>

                <!-- RIGHT COL -->
                <div :class="{'sidebar-spacer-with-margin': clickNotClose}">

                    <div >
                        <div class="relative mb-8">

                            <!-- SEARCH INPUT -->
                            <vs-input class="w-full vs-input-shadow-drop vs-input-no-border d-theme-input-dark-bg" placeholder="Search here"  size="large"  v-model="keyword"/>

                            <!-- SEARCH LOADING -->
                            <!-- <p class="mt-4 text-grey">
                              <feather-icon icon="ClockIcon" svgClasses="w-4 h-4" class="mr-2 align-middle" />
                              <span>Loading...</span>
                            </p> -->

                            <!-- SEARCH ICON -->
                            <div slot="submit-icon" class="absolute top-0 right-0 py-4 px-6" @click="loadListItem()">
                                <feather-icon icon="SearchIcon" svgClasses="h-6 w-6" />
                            </div>

                            <!-- CLEAR INPUT ICON -->
                            <!-- <div slot="reset-icon" class="absolute top-0 right-0 py-4 px-6">
                                <feather-icon icon="XIcon" svgClasses="h-6 w-6 cursor-pointer"  />
                            </div> -->
                        </div>
                    </div>

                    <!-- SEARCH RESULT -->
                    <div>

                        <!-- GRID VIEW -->
                        <template v-if="currentItemView == 'item-grid-view'">
                            <div class="items-grid-view vx-row match-height">
                                <div class="vx-col lg:w-1/3 sm:w-1/2 w-full" v-for="item in listItem" :key="item.objectID">

                                    <item-grid-view :item="item">

                                        <!-- SLOT: ACTION BUTTONS -->
                                        <template slot="action-buttons">
                                            <div class="flex flex-wrap">

                                                <!-- PRIMARY BUTTON: ADD TO WISH LIST -->
                                                <div
                                                    class="item-view-primary-action-btn p-3 flex flex-grow items-center justify-center cursor-pointer"
                                                    @click="toggleItemInWishList(item)">
                                                    <feather-icon icon="HeartIcon" :svgClasses="[{'text-danger fill-current' : isInWishList(item.objectID)}, 'h-4 w-4']" />

                                                    <span class="text-sm font-semibold ml-2">WISHLIST</span>
                                                </div>

                                                <!-- SECONDARY BUTTON: ADD-TO/VIEW-IN CART -->
                                                <div
                                                    class="item-view-secondary-action-btn bg-primary p-3 flex flex-grow items-center justify-center text-white cursor-pointer"
                                                    @click="cartButtonClicked(item)">
                                                    <feather-icon icon="ShoppingBagIcon" svgClasses="h-4 w-4" />

                                                    <span class="text-sm font-semibold ml-2" v-if="isInCart(item.objectID)">VIEW IN CART</span>
                                                    <span class="text-sm font-semibold ml-2" v-else>ADD TO CART</span>
                                                </div>
                                            </div>
                                        </template>
                                    </item-grid-view>

                                </div>
                            </div>
                        </template>

                        <!-- LIST VIEW -->
                        <template v-else>
                            <div class="items-list-view mb-base" v-for="item in listItem" :key="item.objectID">

                                <item-list-view :item="item">

                                    <!-- SLOT: ACTION BUTTONS -->
                                    <template slot="action-buttons">
                                        <div
                                            class="item-view-primary-action-btn p-3 rounded-lg flex flex-grow items-center justify-center cursor-pointer mb-3"
                                            @click="toggleItemInWishList(item)">
                                            <feather-icon icon="HeartIcon" :svgClasses="[{'text-danger fill-current' : isInWishList(item.objectID)}, 'h-4 w-4']" />
                                            <span class="text-sm font-semibold ml-2">WISHLIST</span>
                                        </div>
                                        <div
                                            class="item-view-secondary-action-btn bg-primary p-3 rounded-lg flex flex-grow items-center justify-center text-white cursor-pointer"
                                            @click="cartButtonClicked(item)">
                                            <feather-icon icon="ShoppingBagIcon" svgClasses="h-4 w-4" />

                                            <span class="text-sm font-semibold ml-2" v-if="isInCart(item.objectID)">VIEW IN CART</span>
                                            <span class="text-sm font-semibold ml-2" v-else>ADD TO CART</span>
                                        </div>
                                    </template>
                                </item-list-view>

                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  components: {
    ItemGridView: () => import('./components/ItemGridView.vue'),
    ItemListView: () => import('./components/ItemListView.vue')
  },
  data () {
    return {
      // Filter Sidebar
      isFilterSidebarActive: true,
      clickNotClose: true,
      currentItemView: 'item-grid-view',
      listItem: [],
      keyword:'',
      itemsRate:[5,4,3,2,1]
    }
  },
  computed: {
    toValue () {
      return (value, range) => [
        value.min !== null ? value.min : range.min,
        value.max !== null ? value.max : range.max
      ]
    },

    // GRID VIEW
    isInCart () {
      return (itemId) => this.$store.getters['eCommerce/isInCart'](itemId)
    },
    isInWishList () {
      return (itemId) => this.$store.getters['eCommerce/isInWishList'](itemId)
    },
    windowWidth () { return this.$store.state.windowWidth }
  },
  watch: {
    windowWidth () {
      this.setSidebarWidth()
    }
  },
  methods: {
    setSidebarWidth () {
      if (this.windowWidth < 992) {
        this.isFilterSidebarActive = this.clickNotClose = false
      } else {
        this.isFilterSidebarActive = this.clickNotClose = true
      }
    },

    // GRID VIEW - ACTIONS
    toggleFilterSidebar () {
      if (this.clickNotClose) return
      this.isFilterSidebarActive = !this.isFilterSidebarActive
    },
    toggleItemInWishList (item) {
      this.$store.dispatch('eCommerce/toggleItemInWishList', item)
    },
    additemInCart (item) {
      this.$store.dispatch('eCommerce/additemInCart', item)
    },
    cartButtonClicked (item) {
      this.isInCart(item.objectID) ? this.$router.push('/law/checkout').catch(() => {}) : this.additemInCart(item)
    },
    loadListItem(){
      this.$vs.loading()
      this.$http.post('/api/law/list', { 'keyword' : this.keyword })
      .then((response) => { 
        this.listItem = response.data.list ; 
        this.$vs.loading.close()
      })
      .catch((error)   => { console.log(error) })
    }
  },
  created () {
    this.setSidebarWidth()
    this.loadListItem()
  }
}

</script>


<style lang="scss">
#algolia-instant-search-demo {
  .algolia-header {
    .algolia-filters-label {
      width: calc(260px + 2.4rem);
    }
  }

  #algolia-content-container {

    .vs-sidebar {
      position: relative;
      float: left;
    }
  }

  .algolia-search-input-right-aligned-icon {
    padding: 1rem 1.5rem;
  }

  .algolia-price-slider {
    min-width: unset;
  }

  .item-view-primary-action-btn {
    color: #2c2c2c !important;
    background-color: #f6f6f6;
    min-width: 50%;
  }

  .item-view-secondary-action-btn {
    min-width: 50%;
  }
}

.theme-dark {
  #algolia-instant-search-demo {
    #algolia-content-container {
      .vs-sidebar {
        background-color: #10163a;
      }
    }
  }
}

@media (min-width: 992px) {
  .vs-sidebar-rounded {
    .vs-sidebar {
      border-radius: .5rem;
    }

    .vs-sidebar--items {
      border-radius: .5rem;
    }
  }
}

@media (max-width: 992px) {
  #algolia-content-container {
    .vs-sidebar {
      position: absolute !important;
      float: none !important;
    }
  }
}

</style>