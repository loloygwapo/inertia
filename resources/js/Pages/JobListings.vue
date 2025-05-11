<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const goToApplyPage = (jobId) => {
  router.visit(route('jobs.showApplyForm', jobId));
};

const { jobs, appliedJobIds = [] } = usePage().props;

const appliedIds = ref(appliedJobIds);

const apply = (jobId) => {
  if (appliedIds.value.includes(jobId)) return;

  router.post(route('jobs.apply', jobId), {}, {
    onSuccess: () => {
      appliedIds.value.push(jobId);
    },
    onError: () => {
      alert('Failed to apply.');
    }
  });
};

const paginate = (page) => {
  window.location.href = `/jobs?page=${page}`;
};
</script>

<template>
  <AppLayout>
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold text-center text-gray-900 mb-8">Job Listings</h1>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="job in jobs.data"
          :key="job.id"
          class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition duration-300 ease-in-out"
        >
          <h2 class="text-xl font-semibold text-gray-800">{{ job.title }}</h2>
          <p class="text-gray-600 mt-2">{{ job.description }}</p>
          <div class="mt-4 text-sm text-gray-500">
            <span>Location: {{ job.location }}</span>
          </div>

          <button 
           @click="goToApplyPage(job.id)" 
            :disabled="appliedIds.includes(job.id)"
            :class="appliedIds.includes(job.id)
              ? 'opacity-50 cursor-not-allowed bg-gray-400 text-gray-700'
              : 'bg-blue-500 hover:bg-blue-700 text-white'"
            class="mt-4 px-4 py-2 rounded"
          >
            {{ appliedIds.includes(job.id) ? 'Applied' : 'Apply Now' }}
          </button>
        </div>
      </div>

      <div class="mt-8 flex justify-center">
        <button
          v-if="jobs.current_page > 1"
          @click="paginate(jobs.current_page - 1)"
          class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200"
        >
          Previous
        </button>

        <button
          v-for="page in jobs.last_page"
          :key="page"
          @click="paginate(page)"
          :class="[
            'px-6 py-2 mx-1 rounded-md',
            page === jobs.current_page ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'
          ]"
        >
          {{ page }}
        </button>

        <button
          v-if="jobs.current_page < jobs.last_page"
          @click="paginate(jobs.current_page + 1)"
          class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200"
        >
          Next
        </button>
      </div>
    </div>
  </AppLayout>
</template>
