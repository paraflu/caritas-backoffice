import route from "ziggy-js";
import { Config } from "datatables.net";
import $ from "jquery";
import axios from "axios";

export const createRequest = (
  url: string,
  options: Partial<Config> = {}
): Config => {
  //   const getCookie = (name: string): string | null => {
  //     var match = document.cookie.match(new RegExp("(^| )" + name + "=([^;]+)"));
  //     return match ? match[2] : null;
  //   };
  //   const token =
  //     getCookie("XSRF-TOKEN") ??
  //     (document.head.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)
  //       .attributes["content"].value;

  //   console.log(token, document.cookie);
  //   if (!token) {
  //     console.warn("[createRequest] impossibile recuperare il token");
  //   }

  return {
    serverSide: true,
    processing: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.3/i18n/it-IT.json",
    },
    ajax: (req, callback) =>
      axios.post(url, req).then((res) => callback(res.data)),
    ...options,
  };
};
