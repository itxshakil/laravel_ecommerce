<template>
  <div>
    <div class="mb-8" v-if="itemCount">
      <p class="text-xl mb-2">
        <span v-text="itemCount"></span> item(s) in Shopping Cart
      </p>
      <div class="cart">
        <cart-item
          v-for="item in items"
          :key="item.rowId"
          :data="item"
          @removed="remove"
          @savedforlater="switchtosavelater"
        ></cart-item>
      </div>
      <div class="flex justify-between px-2">
        <p>Your total includes subtotal and 12% tax.</p>
        <div class="cart-total flex">
          <div class="cart-total-left px-2">
            <p>Subtotal</p>
            <p>Tax</p>
            <p class="font-semibold">Total</p>
          </div>
          <div class="cart-total-right">
            <p class="font-semibold">₹<span v-text="subtotal"></span></p>
            <p class="font-semibold">₹<span v-text="tax"></span></p>
            <p class="font-semibold">₹<span v-text="total"></span></p>
          </div>
        </div>
      </div>
      <div class="flex justify-between p-2">
        <a
          href="/shop"
          class="bg-gray-700 text-gray-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs text-center"
          >Continue Shopping</a
        >
        <a
          href="/checkout"
          class="bg-green-700 text-green-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs text-center"
          >Proceed to Checkout</a
        >
      </div>
    </div>
    <div class="text-center mb-8" v-else>
      <p class="text-lg">No Items in Cart.</p>
      <a
        href="/shop"
        class="bg-gray-700 text-gray-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs text-center"
        >Continue Shopping</a
      >
    </div>

    <div class="mb-8" v-if="saveditemCount">
      <p class="text-xl mb-2">
        <span v-text="saveditemCount"></span> item(s) in Saved for later
      </p>
      <div class="cart">
        <div v-for="item in savedItems" :key="item.rowId">
          <saved-item
            :data="item"
            @removed="removesaved"
            @savedtocart="switchtocart"
          ></saved-item>
        </div>
      </div>
    </div>
    <div class="text-center mb-8" v-else>
      <p class="text-lg">No Items is saved for later.</p>
      <a
        href="/shop"
        class="bg-gray-700 text-gray-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs text-center mb-2"
        >Continue Shopping</a
      >
    </div>
  </div>
</template>
<script>
import cartItem from "./CartItem";
import SavedItem from "./SavedItem";
export default {
  props: ["data", "savedforlater"],
  components: { cartItem, SavedItem },
  data() {
    return {
      items: Object.values(this.data),
      savedItems: Object.values(this.savedforlater),
    };
  },
  computed: {
    itemCount() {
      return this.items
        .map((item) => {
          return item.qty;
        })
        .reduce(
          (previousValue, currentValue) => previousValue + currentValue,
          0
        );
    },
    saveditemCount() {
      return this.savedItems.length;
    },
    subtotal() {
      return this.items
        .map((item) => {
          return parseFloat(item.price) * item.qty;
        })
        .reduce(
          (previousValue, currentValue) => previousValue + currentValue,
          0.0
        );
    },
    tax() {
      return this.items
        .map((item) => {
          return parseFloat(item.tax) * item.qty;
        })
        .reduce(
          (previousValue, currentValue) => previousValue + currentValue,
          0
        );
    },
    total() {
      return (this.subtotal + this.tax).toFixed(2);
    },
  },
  methods: {
    remove(item) {
      this.items = this.items.filter((value) => {
        return value.model.slug != item.model.slug;
      });
    },
    switchtosavelater(item) {
      this.items = this.items.filter((value) => {
        return value.model.slug != item.model.slug;
      });

      // Check if already exist
      this.savedItems = this.savedItems.filter((value) => {
        return value.model.slug != item.model.slug;
      });

      this.savedItems.push(item);
    },
    switchtocart(item) {
      this.savedItems = this.savedItems.filter((value) => {
        return value.model.slug != item.model.slug;
      });
      // Check if already exist
      this.items = this.items.filter((value) => {
        return value.model.slug != item.model.slug;
      });

      this.items.push(item);
    },
    removesaved(item) {
      this.savedItems = this.savedItems.filter((value) => {
        return value.model.slug != item.model.slug;
      });
    },
  },
};
</script>