<template>
  <div>
    <div v-if="itemCount">
      <div class="mb-8">
        <p class="text-xl mb-2">
          <span v-text="itemCount"></span> item(s) in Shopping Cart
        </p>
        <div class="cart">
          <div v-for="item in items" :key="item.rowId">
            <cart-item :data="item" @removed="remove"></cart-item>
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
      </div>
    </div>
    <div v-else>
      <div class="text-center mb-8">
        <p class="text-lg">No Items in Cart.</p>
        <a href="/" class="inline-block p-2 bg-gray-200 text-gray-800 rounded">Continue Shopping</a>
      </div>
    </div>
  </div>
</template>
<script>
import cartItem from "./CartItem";
export default {
  props: ["data"],
  components: { cartItem },
  data() {
    return {
      items: Object.values(this.data)
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
    }
  }
};
</script>