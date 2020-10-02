<template>
  <div class="md:w-96 w-full bg-gray-100 md:ml-2 p-2 rounded-lg">
    <h3 class="text-xl leading-loose font-semibold p-2">Ratings</h3>
    <div class="flex p-2">
      <div clas="flex flex-col mr-4">
        <div class="total text-4xl flex items-center">
          <span v-text.number="average" class="mr-2"></span>
          <i class="fa fas fa-star text-yellow-500"></i>
        </div>
        <div class="text-lg text-gray-600 flex">
          <span class="mr-1" v-text="ratings.length"></span> Ratings
        </div>
      </div>
      <div class="flex flex-col w-full ml-2">
        <div v-for="index in 5" :key="index" class="flex items-center">
          <div class="w-2/12 flex items-center">
            <span v-text="index" class="mr-1"></span>
            <i class="inline fa fas fa-star text-yellow-500"></i>
          </div>
          <div class="w-8/12 bg-gray-300 mt-2 rounded-full h-2 mx-2">
            <div
              class="bg-teal-500 text-xs leading-none text-center rounded-full h-2"
              :style="'width: '+perof(index)+'%'"
            ></div>
          </div>
          <div class="w-2/12" v-text="totalof(index)"></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["ratings"],
  computed: {
    average() {
      let length = this.ratings.length;
      if (length == 0) {
        return 0.00;
      }
      let sum = this.ratings
        .map(item => {
          return item.rating;
        })
        .reduce(
          (previousValue, currentValue) => previousValue + currentValue,
          0.0
        );
      return (sum / length).toFixed(2);
    }
  },
  methods: {
    totalof(num) {
      return this.ratings.filter(item => {
        return item.rating == num;
      }).length;
    },
    perof(num) {
      if (this.ratings.length < 1) {
        return 0;
      }
      return (this.totalof(num) / this.ratings.length) * 100;
    }
  }
};
</script>