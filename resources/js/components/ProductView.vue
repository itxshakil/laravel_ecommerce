<template>
  <div class="w-full xl:w-3/4 lg:w-11/12 bg-gray-100 p-5 rounded-lg">
    <div class="md:flex border-2 rounded-lg">
      <div class="md:flex-shrink-0">
        <img class="rounded-lg md:w-56 h-64" :src="product.image" :alt="'Details of '+product.name" />
      </div>
      <div class="pt-4 md:mt-0 md:ml-6">
        <div
          class="uppercase tracking-wide text-sm text-indigo-600 font-bold"
          v-text="product.name"
        ></div>
        <div
          :class="'mr-2 inline-block px-2 bg-'+ stockClass +'-500 text-white rounded'"
          v-text="stockLevel"
        ></div>
        <a
          href="#"
          class="block mt-1 text-lg leading-tight font-semibold text-green hover:underline"
        >
          ₹
          <span v-text="product.price"></span>
        </a>
        <p class="mt-2 text-gray-600 mb-3" v-text="product.details"></p>

        <div class="flex">
          <button
            type="submit"
            class="mr-2 inline-block px-2 bg-blue-500 text-white rounded"
            v-if="isStock"
            @click="addtocart"
            v-text="cartText"
          >Add to cart</button>
          <button
            type="submit"
            class="mr-2 inline-block px-2 bg-blue-500 text-white rounded"
            @click="saveforlater"
            v-text="saveText"
          >Save for later</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["data"],
  data() {
    return {
      product: this.data,
      cartText: "Add to cart",
      saveText: "Save for later"
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
    stockClass() {
      if (this.isStock) {
        return this.product.quantity > 5 ? "green" : "orange";
      }
      return "red";
    }
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
        .post(`/SaveForLater/${this.product.slug}`)
        .then(response => {
          flash("Item is saved for later", "success");
          this.saveText = "Saved for later";
        })
        .catch(error => {
          flash(error.response.data, "warning");
        });
    }
  }
};
</script>