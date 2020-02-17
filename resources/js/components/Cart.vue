<template>
  <div>
    <div v-if="itemCount">
      <div class="mb-8">
        <p class="text-xl mb-2">
          <span v-text="itemCount"></span> item(s) in Shopping Cart
        </p>
        <div class="cart">
          <div v-for="item in items" :key="item.rowId">
            <cart-item :data="item" @removed="remove" @savedforlater="switchtosavelater"></cart-item>
          </div>
        </div>
        <div class="flex justify-between px-2">
          <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis blanditiis voluptates commodi
            vero.
            Impedit odio unde animi aliquam reprehenderit modi.
          </p>
          <div class="cart-total flex">
            <div class="cart-total-left px-2">
              <p>Subtotal</p>
              <p>Tax</p>
              <p class="font-semibold">Total</p>
            </div>
            <div class="cart-total-right">
              <p class="font-semibold" v-text="subtotal"></p>
              <p class="font-semibold" v-text="tax"></p>
              <p class="font-semibold" v-text="total"></p>
            </div>
          </div>
        </div>
        <div class="flex justify-between p-2">
        <a href="/" class="inline-block p-2 bg-gray-200 text-gray-800 rounded">Continue Shopping</a>
        <a href="/" class="inline-block p-2 bg-green-200 text-green-800 rounded">Proceed to Checkout</a>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="text-center mb-8">
        <p class="text-lg">No Items in Cart.</p>
        <a href="/" class="inline-block p-2 bg-gray-200 text-gray-800 rounded">Continue Shopping</a>
      </div>
    </div>

    <div v-if="saveditemCount">
      <div class="mb-8">
        <p class="text-xl mb-2">
          <span v-text="saveditemCount"></span> item(s) in Saved for later
        </p>
        <div class="cart">
          <div v-for="item in savedItems" :key="item.rowId">
            <saved-item :data="item" @removed="removesaved" @savedtocart="switchtocart"></saved-item>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="text-center mb-8">
        <p class="text-lg">No Items is saved for later.</p>
        <a href="/" class="inline-block p-2 bg-gray-200 text-gray-800 rounded">Continue Shopping</a>
      </div>
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
      savedItems: Object.values(this.savedforlater)
    };
  },
  computed: {
    itemCount() {
      return this.items
        .map(item => {
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
        .map(item => {
          return parseFloat(item.price) * item.qty;
        })
        .reduce(
          (previousValue, currentValue) => previousValue + currentValue,
          0.0
        );
    },
    tax() {
      return this.items
        .map(item => {
          return parseFloat(item.tax) * item.qty;
        })
        .reduce(
          (previousValue, currentValue) => previousValue + currentValue,
          0
        );
    },
    total() {
      return this.subtotal + this.tax;
    }
  },
  methods: {
    remove(item) {
      this.items = this.items.filter(value => {
        return value.model.slug != item.model.slug;
      });
    },
    switchtosavelater(item) {
      this.items = this.items.filter(value => {
        return value.model.slug != item.model.slug;
      });

      // Check if already exist
      this.savedItems = this.savedItems.filter(value => {
        return value.model.slug != item.model.slug;
      });

      this.savedItems.push(item);
    },
    switchtocart(item) {
      this.savedItems = this.savedItems.filter(value => {
        return value.model.slug != item.model.slug;
      });
      // Check if already exist
      this.items = this.items.filter(value => {
        return value.model.slug != item.model.slug;
      });

      this.items.push(item);
    },
    removesaved(item) {
      this.savedItems = this.savedItems.filter(value => {
        return value.model.slug != item.model.slug;
      });
    }
  }
};
</script>