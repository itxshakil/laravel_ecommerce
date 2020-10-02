<template>
  <div class="flex items-center justify-between border-b-2 p-2 text-sm sm:text-base">
    <img
      :src="item.model.image"
      :alt="'Details of '+item.model.name"
      width="100"
      height="100"
    />
    <a :href="'/products/'+item.model.slug" class="mx-2" v-text="item.name"></a>
    <div class="flex-shrink-0 p-2 text-center">
      <div class="cursor-pointer" @click="remove(item)">Remove</div>
      <div class="cursor-pointer" @click="savetocart(item)">Save to Cart</div>
    </div>
    <p class="font-semibold" title="Product price">₹<span v-text="item.price"></span></p>
  </div>
</template>
<script>
export default {
  props: ["data"],
  data() {
    return {
      item: this.data
    };
  },
  methods: {
    remove(item) {
      axios.delete("/saveForLater/" + item.model.slug).then(response => {
        flash(response.data.message, "danger");
      });
      this.$emit("removed", item);
    },
    savetocart(item) {
      axios
        .post("/saveForLater/switchToSaveToCart/" + item.model.slug)
        .then(response => {
          flash(response.data.message, "success");
        })
        .catch(error => {
          flash(error.response.data.message, "warning");
        });
      this.$emit("savedtocart", item);
    }
  }
};
</script>