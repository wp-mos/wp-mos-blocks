import { useBlockProps } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";

const Edit = () => {
  const blockProps = useBlockProps();

  return (
    <>
      <div {...blockProps}>{__("This block is not editable.", "mos")}</div>
    </>
  );
};

export default Edit;
