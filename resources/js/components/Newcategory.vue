<template>
  <div>
    <a
      v-for="category in categories"
      :key="category.id"
      class="capitalize"
      :href="'/admin/products?category='+category.slug"
      v-text="category.name"
    ></a>
    <p class="pt-4 font-semibold">Add new category</p>
    <form class="flex pt-2 -ml-4 pr-2" @submit.prevent="add">
      <input
        class="flex-shrink pl-3 py-2 text-sm leading-tight text-gray-700 border rounded-full rounded-r-none shadow appearance-none focus:outline-none"
        id="category"
        type="text"
        placeholder="new category"
        name="category"
        v-model="category"
        required
      />
      <input
        type="submit"
        value="Add"
        class="w-16 px-1 py-2 uppercase leading-tight text-gray-700 border rounded-full rounded-l-none shadow appearance-none focus:outline-none font-bold text-xs"
      />
    </form>
  </div>
</template>
<script>
export default {
  data() {
    return {
      category: "",
      categories: []
    };
  },
  methods: {
    add() {
      axios
        .post("/admin/categories", { name: this.category })
        .then(response => {
          this.category = "";
          this.categories.push(response.data);
        })
        .catch(error => {
          flash(error.response.data.errors.name[0], "danger");
        });
    }
  }
};
</script>