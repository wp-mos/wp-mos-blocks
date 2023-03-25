import { registerBlockType } from "@wordpress/blocks";

import "./index.css";

import Edit from "./edit";

registerBlockType("mos/user-content", {
  edit: Edit,
});
