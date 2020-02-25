<template>
  <div class="flex items-center justify-between border-b-2 p-2">
    <img
      :src="'/storage/'+item.model.image"
      :alt="'Details of '+item.model.name"
      width="100"
      height="100"
    />
    <a :href="'/products/'+item.model.slug" class="mx-2" v-text="item.name"></a>
    <div class="flex-shrink-0 m-2">
      <div class="cursor-pointer" @click="remove(item)">Remove</div>
      <div class="cursor-pointer" @click="saveforlater(item)">Save for Later</div>
    </div>
    <select
      v-model.number="quantity"
      class="block uppercase tracking-wide text-gray-700 text-xs font-bold p-1 mr-2 w-12 h-8 border"
      for="grid-state"
      @change="updateQuantity"
    >
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
    </select>
    <p class="font-semibold" v-text="item.price"></p>
  </div>
</template>
<script>
export default {
  props: ["data"],
  data() {
    return {
      item: this.data,
      quantity: this.data.qty
    };
  },
  methods: {
    remove(item) {
      axios.delete("/cart/" + item.model.slug).then(response => {
        flash("Item is removed from cart", "danger");
      });
      this.item.qty = this.quantity;
      this.$emit("removed", item);
    },
    saveforlater(item) {
      axios
        .post("/cart/switchToSaveForLater/" + item.model.slug)
        .then(response => {
          flash("Item is saved for later", "success");
        })
        .catch(error => {
          flash(error.response.data, "warning");
        });
      this.$emit("savedforlater", item);
    },
    updateQuantity() {
      axios
        .patch("/cart/" + this.item.model.slug, { quantity: this.quantity })
        .then(response => {
          this.item.qty = this.quantity;
          flash("Item Quantity updated successfully", "success");
        })
        .catch(error => {
          flash(error.response.data.message, "warning");
        });
    }
  }
};
</script>