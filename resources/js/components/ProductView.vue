<template>
  <div class="w-full">
    <div class="flex flex-col md:flex-row">
      <div class="w-full xl:w-3/4 lg:w-8/12 bg-gray-100 mr-2 rounded-lg mb-2 pb-2 md:pb-0">
        <div class="md:flex rounded-lg">
          <div class="md:flex-shrink-0">
            <img
              class="rounded-lg w-full md:w-56 h-64"
              :src="product.image"
              :alt="'Details of '+product.name"
            />
          </div>
          <div class="pt-4 px-4 md:px-0 md:mt-0 md:ml-6">
            <div class="flex md:flex-col items-baseline">
              <div
                class="uppercase tracking-wide text-sm text-indigo-600 font-bold flex-grow"
                v-text="product.name"
              ></div>
              <div
                :class="'mr-2 inline-block px-2 bg-'+ stockClass +'-500 text-white rounded'"
                v-text="stockLevel"
              ></div>
            </div>
            <div class="block mt-1 text-lg leading-tight font-semibold">
              ₹
              <span v-text="product.price"></span>
            </div>
            <p class="mt-2 text-gray-600 mb-3" v-text="product.details"></p>

            <div class="flex">
              <button
                type="submit"
                class="bg-blue-500 active:bg-blue-400 text-gray-100 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs"
                v-if="isStock"
                @click="addtocart"
              ><i class="fa fas fa-shopping-cart mr-1"></i><span 
                v-text="cartText"></span></button>
              <button
                type="submit"
                class="bg-gray-100 active:bg-gray-200 text-gray-800 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs"
                @click="saveforlater"
              ><i class="fa fas text-red-500 mr-1" :class="saved ? 'fa-heart' : 'fa-heart-o'"></i><span 
                v-text="saveText"></span></button>
            </div>
          </div>
        </div>
      </div>
      <review-info :data="ratings"></review-info>
    </div>
    <div v-if="ratings"></div>
    <h3 class="text-xl my-2">Reviews</h3>
    <div v-for="rating in ratings" :key="rating.id">
      <rating :data="rating" @deleted="remove"></rating>
    </div>
    <new-rating v-if="canAdd" :data="product" @created="addReview"></new-rating>
  </div>
</template>
<script>
import rating from "./Rating";
import newRating from "./NewRating";
import reviewInfo from "./ReviewInfo";
export default {
  props: ["data"],
  components: { rating, newRating, reviewInfo },
  data() {
    return {
      product: this.data,
      ratings: this.data.ratings,
      cartText: "Add to cart",
      saveText: "Save",
      saved:false
    };
  },
  computed: {
    stockLevel() {
      if (this.isStock) {
        return this.product.quantity > 5 ? "Available" : "Low Stock";
      }
      return "Not Available";
    },
    isStock() {
      if (this.product.quantity > 0) {
        return true;
      }
      return false;
    },
    canAdd() {
      if (auth_user == null) {
        return true;
      }

      let userRating = this.ratings.filter(item => {
        return item.user_id == auth_user.id;
      });
      return userRating.length > 0 ? false : true;
    },
    stockClass() {
      if (this.isStock) {
        return this.product.quantity > 5 ? "green" : "orange";
      }
      return "red";
    },
  },
  methods: {
    addtocart() {
      axios
        .post(`/cart/${this.product.slug}`)
        .then(response => {
          flash("Item is saved to cart", "success");
          this.cartText = "Added to cart";
        })
        .catch(error => {
          flash(error.response.data, "warning");
        });
    },
    saveforlater() {
      axios
        .post(`/saveForLater/${this.product.slug}`)
        .then(response => {
          flash("Item is saved for later", "success");
          this.saveText = "Saved";
          this.saved=true;
        })
        .catch(error => {
          flash(error.response.data, "warning");
        });
    },
    addReview(data) {
      this.ratings.push(data);
    },
    remove(id) {
      this.ratings = this.ratings.filter(item => {
        return item.id != id;
      });
    }
  }
};
</script>