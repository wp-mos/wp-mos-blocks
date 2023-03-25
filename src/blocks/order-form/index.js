import { registerBlockType } from "@wordpress/blocks";

import Edit from "./edit";

import "./index.css";

registerBlockType("mos/order-form", {
  edit: Edit,
});
