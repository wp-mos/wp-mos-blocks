import { useBlockProps } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";

const Edit = () => {
  const blockProps = useBlockProps();

  return (
    <>
      <div {...blockProps}>
        <a className="mos-block-auth-button" href="#">
          {__("Sign in", "mos")}
        </a>
      </div>
    </>
  );
};

export default Edit;
