import http from "k6/http";
import { sleep, check } from "k6";

export let options = {
  vus: 20,          // jumlah user bersamaan
  duration: "1m",   // durasi tes
};

export default function () {
  let res = http.get("http://localhost:8000"); // ganti sesuai URL Laravel kamu

  check(res, {
    "status 200": (r) => r.status === 200,
    "response < 2s": (r) => r.timings.duration < 2000,
  });

  sleep(1);
}
