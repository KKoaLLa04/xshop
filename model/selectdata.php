<?php
// ----------------------------------------------------------------- ADMIN -----------------------------------------------------------------
// -----------------------------------------------------------------
// ADMIN PRODUCTS CATEGORY
// -----------------------------------------------------------------
function adminProductCate($filter, $offset, $perPage)
{
    return getRaw("SELECT type.* FROM type $filter ORDER BY id DESC LIMIT $offset,$perPage");
}

function countType()
{
    return getRows("SELECT id FROM type");
}

function cateDetail($id)
{
    return firstRaw("SELECT * FROM type WHERE id=$id");
}

function deleteCate($id)
{
    return getRows("SELECT id FROM products WHERE type_id=$id");
}

// -----------------------------------------------------------------
// ADMIN PRODUCTS
// -----------------------------------------------------------------
function allProducts($filter, $offset, $perPage)
{
    return getRaw("SELECT products.*, type.name as type_name FROM products INNER JOIN type ON type.id=products.type_id $filter ORDER BY products.id DESC LIMIT $offset,$perPage");
}

function allType()
{
    return getRaw("SELECT * FROM type ORDER BY id DESC");
}

function countProduct($filter = '')
{
    return getRows("SELECT id FROM products $filter");
}

function listProduct()
{
    return getRaw("SELECT * FROM products ORDER BY id DESC");
}

// -----------------------------------------------------------------
// MANAGER + CLIENT
// -----------------------------------------------------------------

function countClient($filter = '')
{
    return getRows("SELECT id FROM client $filter");
}

function allAdmin($offset, $perPage)
{
    return getRaw("SELECT * FROM client WHERE position <> 0 ORDER BY position DESC LIMIT $offset, $perPage");
}

function clientEmail($email = '')
{
    return getRows("SELECT * FROM client WHERE email='$email'");
}

function allClient($filter, $offset, $perPage)
{
    return getRaw("SELECT * FROM client $filter WHERE position=0 ORDER BY id LIMIT $offset, $perPage");
}

function clientDetail($id)
{
    return firstRaw("SELECT * FROM client WHERE id=$id");
}

function checkEmailClient($email, $id)
{
    return getRows("SELECT * FROM client WHERE email='$email' AND id<>$id");
}
// -----------------------------------------------------------------
// COMMENTS TABLE
// -----------------------------------------------------------------

function countComment()
{
    return getRows("SELECT id FROM comments");
}

function allComments($filter, $offset, $perPage)
{
    return getRaw("SELECT comments.*,fullname,name FROM comments INNER JOIN client ON client.id=comments.client_id INNER JOIN products ON products.id=comments.product_id $filter ORDER BY id LIMIT $offset, $perPage");
}

function commentDetail($id)
{
    return firstRaw("SELECT comments.*,name,fullname FROM comments INNER JOIN products ON products.id=comments.product_id INNER JOIN client ON client.id=comments.client_id WHERE comments.id=$id");
}

// -----------------------------------------------------------------
// BILL TABLE
// -----------------------------------------------------------------
function countBill($filter = '')
{
    return getRows("SELECT id FROM bill $filter");
}

function allBill($filter, $offset, $perPage)
{
    return getRaw("SELECT * FROM bill $filter ORDER BY client_id DESC LIMIT $offset, $perPage");
}

// -----------------------------------------------------------------
// STATISTIC 
// -----------------------------------------------------------------
function allChart()
{
    return getRaw("SELECT type.*,count(products.id) as count_id, max(products.price) as max_price ,min(products.price) as min_price,avg(products.price)  as avg_price FROM type INNER JOIN products ON products.type_id=type.id WHERE products.type_id=type.id GROUP BY type.id ORDER BY id DESC");
}

function productByPrice()
{
    return getRaw("SELECT * FROM products ORDER BY price DESC");
}


// ------------------------------------------------------------------CLIENT --------------------------------------------------------------------------------
// ---------------------
// account
// --------------------
function clientDetailAccount($clientId)
{
    return firstRaw("SELECT * FROM client WHERE id=$clientId");
}

// ---------------------
// bill
// ---------------------
function cartDetailBill($codeId)
{
    return getRaw("SELECT * FROM cart WHERE code_id=$codeId");
}

function allCartBill($clientId)
{
    return getRaw("SELECT * FROM cart WHERE client_id=$clientId AND status=1 ORDER BY id DESC");
}
function allClientBill($clientId)
{
    return getRaw("SELECT * FROM bill WHERE client_id=$clientId ORDER BY id DESC");
}

// ----------------------
// cart
// ----------------------
function cartProductDetail($productId)
{
    return firstRaw("SELECT * FROM products WHERE id=$productId");
}

function cartFirstDetail($id)
{
    return firstRaw("SELECT * FROM products WHERE id=$id");
}

function listBillDetail($clientId)
{
    return firstRaw("SELECT * FROM bill WHERE client_id=$clientId ORDER BY id DESC");
}

function allCart($clientId)
{
    return getRaw("SELECT * FROM cart WHERE client_id=$clientId AND status=0 ORDER BY id DESC");
}

function cartDetail($id)
{
    return firstRaw("SELECT * FROM cart WHERE id=$id");
}

// ------------------------------------
// category
// ------------------------------------
function firstCate($id)
{
    return firstRaw("SELECT * FROM type WHERE id = $id ORDER BY id DESC");
}

function allCate($id)
{
    return getRaw("SELECT * FROM products WHERE type_id=$id");
}

// ------------------------------------
// comment
// ------------------------------------
function allComment()
{
    return getRaw("SELECT comments.*,fullname,name, products.id as product_detail FROM comments INNER JOIN client ON client.id=comments.client_id INNER JOIN products ON products.id=comments.product_id ORDER BY comments.id DESC");
}


function allClientComment($clientId)
{
    return getRaw("SELECT comments.*,fullname,name, products.id as product_detail FROM comments INNER JOIN client ON client.id=comments.client_id INNER JOIN products ON products.id=comments.product_id WHERE client_id=$clientId ORDER BY comments.id DESC");
}


// ------------------------------------
// home
// ------------------------------------
function productLimit()
{
    return getRaw("SELECT * FROM products ORDER BY id DESC LIMIT 0,9");
}

// ------------------------------------
// login
// ------------------------------------
function clientToken($token)
{
    return firstRaw("SELECT * FROM client WHERE token='$token'");
}

function checkEmailExit($email)
{
    return getRows("SELECT * FROM client WHERE email='$email'");
}

function checkAccountExit($email)
{
    return firstRaw("SELECT * FROM client WHERE email='$email'");
}

function forgotToken($token)
{
    return firstRaw("SELECT * FROM client WHERE forgot='$token'");
}

// ------------------------------
// products
// -------------------------------
function clientAllProduct($filter, $offset, $perPage)
{
    return getRaw("SELECT * FROM products $filter ORDER BY id DESC LIMIT $offset,$perPage");
}

function productClientDetail($id)
{
    return firstRaw("SELECT products.*,type.name as type_name FROM products INNER JOIN type ON type.id=products.type_id WHERE products.id = $id");
}

function productCommentDetail($id)
{
    return getRaw("SELECT comments.*,fullname FROM comments INNER JOIN client ON client.id=client_id WHERE product_id=$id ORDER BY comments.id DESC");
}

function clientProductLimit($typeId, $id)
{
    return getRaw("SELECT * FROM products WHERE type_id=$typeId AND id <> $id ORDER BY id DESC LIMIT 0,4");
}
