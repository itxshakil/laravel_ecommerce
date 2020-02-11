<template>
  <div class="flex items-center justify-between border-b-2 p-2">
    <img
      :src="'/storage/'+item.model.image"
      :alt="'Details of '+item.model.name"
      width="100"
      height="100"
    />
    <a :href="'/products/'+item.model.slug" class="mx-2" v-text="item.name"></a>
    <div>
      <div class="cursor-pointer" @click="remove(item)">Remove</div>
      <div class="cursor-pointer" @click="savetocart(item)">Save to Cart</div>
    </div>
    <p class="font-semibold" v-text="item.price"></p>
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
        console.log("removed from saved later successfully");
      });
      this.$emit("removed", item);
    },
    savetocart(item) {
      axios
        .post("/saveForLater/switchToSaveToCart/" + item.model.slug)
        .then(response => {
          console.log("saved to cart successfully");
        });
      this.$emit("savedtocart", item);
    }
  }
};
</script>