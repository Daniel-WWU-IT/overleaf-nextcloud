<script setup>
import { onMounted } from "vue";

import axios from "@nextcloud/axios";
import { loadState } from "@nextcloud/initial-state";

const overleafURL = loadState("overleafv6_nextcloud", "overleaf_url");
const overleafEmail = loadState("overleafv6_nextcloud", "overleaf_email");
const overleafPassword = loadState("overleafv6_nextcloud", "overleaf_password");

onMounted(() => {
  const cleanHeaders = { requesttoken: undefined };

  axios.get(new URL("/login", overleafURL).href, {
    withCredentials: true,
    responseType: "text",
    headers: cleanHeaders
  }).then(({ data }) => {
    const doc = new DOMParser().parseFromString(data, "text/html");
    const csrfElements = doc.getElementsByName("_csrf");
    if (csrfElements.length >= 0) {
      return axios.post(
          new URL("/login", overleafURL).href,
          {
            "_csrf": csrfElements[0].value,
            "email": overleafEmail,
            "password": overleafPassword
          },
          {
            withCredentials: true,
            headers: cleanHeaders
          }
      );
    }
  }).then((res) => {
    if (res) {
      window.location.replace(new URL(res.data.redir, overleafURL).href);
    }
  });
});
</script>

<template>
  <div id="app-frame" style="width: 100%; height: 100%">
    <div class="overleaf-loader">Overleaf V6 ready, redirecting...</div>
  </div>
</template>

<style lang="scss" scoped>
.overleaf-loader {
  width: 100%;
  font-weight: bold;
  font-size: larger;
  color: white;
  text-align: center;
}
</style>
