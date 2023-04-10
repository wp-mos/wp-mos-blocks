document.addEventListener("DOMContentLoaded", () => {
  const apiUrl = "https://lasercut.internetguru.io/api/v2/analyze?id=mos";

  const orderForm = document.getElementById("mos-order-form");
  const formGroup = document.querySelector(".order-form-group");
  const totalPriceElm = document.getElementById("order-form-total-price");
  const addGroup = document.getElementById("order-form-add");
  const beforeGroup = document.querySelector(".order-form-add-group");
  const firstFileInput = document.getElementById("order-form-file-0");
  const firstFileLabel = document.querySelector(
    ".form-subscribe-button[for='order-form-file-0']"
  );

  const closeIcon = `
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M6 18L18 6" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
      <path d="M18 18L6 6" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  `;

  const data = [];
  const loader = "...";
  let lastId = 0;

  let totalPrice = null;

  // Translate
  let currentLink = window.location.href;
  let fileText = "";
  let materialText = "";
  let quantityText = "";
  let dimensionsText = "";
  let priceText = "";

  if (currentLink.includes("/en/")) {
    fileText = "File";
    materialText = "Material";
    quantityText = "Quantity";
    dimensionsText = "Dimensions";
    priceText = "Price";
  } else if (currentLink.includes("/hu/")) {
    fileText = "Fájl Név";
    materialText = "Anyag";
    quantityText = "Énekelni";
    dimensionsText = "Méretek";
    priceText = "Ár";
  } else {
    fileText = "Fișier";
    materialText = "Material";
    quantityText = "Cantitate";
    dimensionsText = "Dimensiuni";
    priceText = "Preț";
  }

  // Init data
  const initData = (id, group) => {
    data[id] = {
      group: group,
      status: null,
      prices: null,
      lastMod: null,
      material: null,
      quantity: null,
      file: null,
      fileHash: null,
      fileURL: null,
      fileWidth: null,
      fileHeight: null,
      productPrice: null,
      addedGroup: false,
      valid: false,
    };
  };

  // Listen for form group change
  const formGroupListener = (group, id) => {
    group.addEventListener("change", () => {
      getResult(id);
    });
  };

  const updateGroup = (id) => {
    totalPrice = 0;
    data.forEach((group) => {
      if (group === null || group.prices === null) {
        return;
      }

      if (id && id === group.group.getAttribute("data-id")) {
        group.status.innerHTML = loader;
      }

      const materialSelect = group.group.querySelector(".order-form-material");

      if (materialSelect.children.length == 1) {
        materialSelect.innerHTML = "";

        group.prices.forEach((priceData) => {
          const option = document.createElement("option");
          option.value = priceData.material_id;
          option.innerHTML = `${priceData.material_name}`;
          option.setAttribute("data-name", priceData.material_name);
          materialSelect.appendChild(option);
        });
      }

      const quantity = group.group.querySelector(".order-form-quantity").value;
      const price =
        group.prices[materialSelect.selectedIndex].unit_price * quantity +
        group.prices[materialSelect.selectedIndex].fix_price;

      setTimeout(() => {
        group.status.innerHTML = `${Math.round(price)} RON`;
      }, 300);

      let width = Math.round(group.fileWidth);
      let height = Math.round(group.fileHeight);

      group.group.querySelector(
        ".order-form-dimensions"
      ).innerHTML = `${width} x ${height} mm`;

      group.productPrice =
        group.prices[materialSelect.selectedIndex].unit_price;
      totalPrice += price;
      group.material =
        materialSelect[materialSelect.selectedIndex].getAttribute("data-name");
    });
    totalPriceElm.innerHTML = `${Math.round(totalPrice)} RON`;
  };

  // Update form group
  const getResult = (id) => {
    const group = data[id].group;
    const groupFile = group.querySelector(".order-form-file");
    const groupMaterial = group.querySelector(".order-form-material");
    const groupQuantity = group.querySelector(".order-form-quantity");
    const formStatus = group.querySelector(".order-form-status");

    // Get material & quantity values
    const groupMaterialValue = groupMaterial.value;
    const groupQuantityValue = groupQuantity.value;

    // Get material name
    const groupMaterialName =
      groupMaterial.options[groupMaterial.selectedIndex].text;

    // Get file
    let file = null;
    if (data[id].file == null) {
      if (!groupFile.value) {
        formStatus.innerHTML = "No file selected.";
        return;
      }
      file = groupFile.files[0];
    } else {
      file = data[id].file;
    }

    // Check if quantity is valid
    if (groupQuantityValue < 1 || groupQuantityValue > 100) {
      formStatus.innerHTML = "Quantity must be between 1 and 100.";
      return;
    }

    const fileName = file.name;
    const lastMod = file.lastModified + fileName;

    // Set quantity
    data[id].quantity = groupQuantityValue;

    if (data[id].lastMod !== lastMod) {
      data[id].status = formStatus;
      data[id].material = groupMaterialValue;
      data[id].lastMod = lastMod;

      const form = new FormData();
      form.append("material", groupMaterialValue);
      form.append("amount", groupQuantityValue);

      if (data[id].valid && data[id].fileHash !== null) {
        form.append("hash", data[id].fileHash);
      } else {
        form.append("dxf_file", file, fileName);
      }

      formStatus.innerHTML = loader;

      fetch(apiUrl, {
        method: "POST",
        body: form,
      })
        .then((response) => {
          if (response.ok) {
            return response.json();
          }
          return response.json().then((text) => {
            throw new Error(text.message);
          });
        })
        .then((result) => {
          data[id].prices = result.prices;
          data[id].materialPrices = result.prices;
          data[id].fileHash = result.file_hash;
          data[id].fileURL = result.file_path;
          data[id].fileWidth = result.model_width;
          data[id].fileHeight = result.model_height;
          data[id].file = file;
          data[id].valid = true;
          if (!data[id].group) {
            // add new group
            data[id].addedGroup = true;
          }
          updateGroup(id);
        })
        .catch((error) => {
          console.log(error);
          formStatus.innerHTML = error;
          data[id].lastMod = null;
          data[id].valid = false;
        });
      return;
    }

    data[id].material = groupMaterialValue;
    updateGroup(id);
    data[id].valid = true;
  };

  const buildBlock = (id) => {
    const newGroup = document.createElement("div");
    newGroup.classList.add("order-form-group");
    newGroup.dataset.id = `${id}`;

    // Add file block
    const fileBlock = document.createElement("div");
    fileBlock.classList.add("order-form-block", "order-form-block-file");
    const formMeta = document.createElement("div");
    formMeta.classList.add("order-form-label");
    formMeta.innerHTML = fileText;
    const formBlockLabel = document.createElement("label");
    formBlockLabel.classList.add(
      "form-subscribe-button",
      "form-subscribe-button-secondary"
    );
    formBlockLabel.setAttribute("for", `order-form-file-${id}`);
    formBlockLabel.innerHTML = "DXF File";
    const formBlockInput = document.createElement("input");
    formBlockInput.setAttribute("id", `order-form-file-${id}`);
    formBlockInput.classList.add("order-form-file");
    formBlockInput.setAttribute("type", "file");
    formBlockInput.setAttribute("name", `file-${id}`);
    formBlockInput.setAttribute("required", true);
    formBlockInput.addEventListener("change", (event) => {
      const file = event.target.files[0];
      const fileName = file.name;
      formBlockLabel.innerHTML = fileName;
    });
    fileBlock.appendChild(formMeta);
    fileBlock.appendChild(formBlockLabel);
    fileBlock.appendChild(formBlockInput);

    // Add material block
    const materialBlock = document.createElement("div");
    materialBlock.classList.add("order-form-block", "order-form-block-35");
    const materialBlockLabel = document.createElement("label");
    materialBlockLabel.classList.add("order-form-label");
    materialBlockLabel.setAttribute("for", `material-${id}`);
    materialBlockLabel.innerHTML = materialText;
    const materialBlockSelect = document.createElement("select");
    materialBlockSelect.classList.add(
      "order-form-material",
      "order-form-select"
    );
    materialBlockSelect.setAttribute("name", `material-${id}`);
    // materialBlockSelect.setAttribute("required", true);
    const materialBlockSelectOption = document.createElement("option");
    materialBlockSelectOption.innerHTML = "Choose file";
    materialBlockSelectOption.setAttribute("value", "");
    materialBlockSelect.appendChild(materialBlockSelectOption);
    materialBlock.appendChild(materialBlockLabel);
    materialBlock.appendChild(materialBlockSelect);

    // Add quantity block
    const quantityBlock = document.createElement("div");
    quantityBlock.setAttribute("required", true);
    quantityBlock.classList.add("order-form-block", "order-form-block-10");
    const quantityBlockLabel = document.createElement("label");
    quantityBlockLabel.classList.add("order-form-label");
    quantityBlockLabel.setAttribute("for", `quantity-${id}`);
    quantityBlockLabel.innerHTML = quantityText;
    const quantityBlockInput = document.createElement("input");
    quantityBlockInput.classList.add(
      "order-form-quantity",
      "order-form-select"
    );
    quantityBlockInput.setAttribute("name", `quantity-${id}`);
    quantityBlockInput.setAttribute("type", "number");
    quantityBlockInput.setAttribute("required", true);
    quantityBlockInput.setAttribute("min", 1);
    quantityBlockInput.setAttribute("max", 100);
    quantityBlockInput.setAttribute("value", 1);
    quantityBlock.appendChild(quantityBlockLabel);
    quantityBlock.appendChild(quantityBlockInput);

    // Add status block
    const statusBlock = document.createElement("div");
    statusBlock.classList.add("order-form-block-status", "order-form-block-20");

    const statusOrderFormSubBlockDimensions = document.createElement("div");
    statusOrderFormSubBlockDimensions.classList.add("order-form-sub-block");
    const statusLabelDimmensions = document.createElement("div");
    statusLabelDimmensions.classList.add("order-form-label");
    statusLabelDimmensions.innerHTML = dimensionsText;
    const statusBlockDimensions = document.createElement("div");
    statusBlockDimensions.classList.add("order-form-dimensions");
    statusBlockDimensions.innerHTML = "-";

    statusOrderFormSubBlockDimensions.appendChild(statusLabelDimmensions);
    statusOrderFormSubBlockDimensions.appendChild(statusBlockDimensions);

    const statusBlockPrice = document.createElement("div");
    statusBlockPrice.classList.add("order-form-status");
    const statusOrderFormSubBlockPrice = document.createElement("div");
    statusOrderFormSubBlockPrice.classList.add("order-form-sub-block");
    const statusLabelPrice = document.createElement("div");
    statusLabelPrice.classList.add("order-form-label");
    statusLabelPrice.innerHTML = priceText;
    statusBlockPrice.innerHTML = "-";

    statusOrderFormSubBlockPrice.appendChild(statusLabelPrice);
    statusOrderFormSubBlockPrice.appendChild(statusBlockPrice);

    statusBlock.appendChild(statusOrderFormSubBlockDimensions);
    statusBlock.appendChild(statusOrderFormSubBlockPrice);

    // Close button
    const closeButtonBlock = document.createElement("div");
    closeButtonBlock.classList.add("order-form-close");
    const closeButton = document.createElement("button");
    closeButton.dataset.id = `${id}`;
    closeButton.classList.add("order-form-close-button");
    closeButton.setAttribute("type", "button");
    closeButton.innerHTML = closeIcon;
    closeButtonBlock.appendChild(closeButton);

    newGroup.appendChild(fileBlock);
    newGroup.appendChild(materialBlock);
    newGroup.appendChild(quantityBlock);
    newGroup.appendChild(statusBlock);
    newGroup.appendChild(closeButtonBlock);

    orderForm.insertBefore(newGroup, beforeGroup);

    closeButton.addEventListener("click", (event) => {
      const id = event.currentTarget.dataset.id;
      data[id] = null;
      formGroup.parentNode.removeChild(newGroup);

      const filterData = data.filter((item) => item !== null);
      const lastElement = filterData.pop();
      lastId = data.indexOf(lastElement);
    });
    return newGroup;
  };

  const init = () => {
    initData(0, formGroup);
    formGroupListener(formGroup, 0);
    firstFileInput.addEventListener("change", (event) => {
      const file = event.target.files[0];
      const fileName = file.name;
      firstFileLabel.innerHTML = fileName;
    });
  };

  init();

  const addGroupHandler = () => {
    const currentGroup = data[lastId].group;
    const currentGroupFile = currentGroup.querySelector(".order-form-file");

    if (!currentGroupFile.files[0]) return;

    lastId++;
    let newGroup = buildBlock(lastId);
    initData(lastId, newGroup);
    formGroupListener(newGroup, lastId);
  };

  // Add new group
  addGroup.addEventListener("click", () => addGroupHandler());

  orderForm.addEventListener("submit", async (event) => {
    event.preventDefault();
    const formData = new FormData(orderForm);

    dataClened = data.filter((item) => item !== null);

    dataClened.forEach((item, index) => {
      if (item) {
        const { productPrice, material } = item;
        formData.append(`material-${index}`, material);
        formData.append(`price-${index}`, productPrice);
      }
    });

    try {
      const response = await fetch(settings.root, {
        method: "POST",
        // body: JSON.parse(formData),
        body: formData,
        headers: {
          // "Content-Type": "application/json",
          "X-WP-Nonce": settings.nonce,
        },
      });
      if (response.ok) {
        const data = await response.json();
        const checkoutUrl = data["checkout_url"];
        orderForm.reset();
        location.replace(checkoutUrl);
      } else {
        console.log("Error:", response.status);
      }
    } catch (error) {
      console.log("Error:", error);
    }
  });

  orderForm.reset();
});
