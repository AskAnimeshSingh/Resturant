<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Extra;
use App\Models\ProductAddOn;
use App\Models\ProductExtra;
use App\Models\Products;
use App\Models\Propertie;
use App\Models\PropertiesItems;
use App\Models\Size;
use App\Models\Type;
use App\Models\Variation;
use App\Models\ProductProperty;
use App\Models\ProductVarients;
use App\Models\IndItem;
use App\Models\ProductToppings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class Product extends Controller
{
    /**
     * @return view product view
     */
    public function index()
    {
        $category = Category::where(['status' => 1])->get();
        $sizes = Size::where(['status' => 1])->get();
        $types = Type::where(['status' => 1])->get();
        $extras = Extra::where(['status' => 1])->get();
        $variations = Variation::where(['status' => 1])->get();
        $properties = Propertie::where(['status' => 1])->get();
        $ingridents = IndItem::where(['status' => 1])->get();
        return view('admin.product.create', compact('category', 'ingridents', 'sizes', 'types', 'extras', 'properties', 'variations'));
    }

    /**
     * @param Request $request
     * @method use for store product
     */
    public function store(Request $request)
    {
        $rules = [];

        if (!empty($request->properties_check) && $request->properties_check === 'on') {
            $rules = ['properties' => 'required'];
        }

        if (!empty($request->variations_check) && $request->variations_check === 'on') {
            $rules = ['variations' => 'required'];
            $rules = ['variant_price' => 'required'];
        }

        if ($request->sub_category != "") {
            $rules = ['sub_category' => 'required|exists:sub_categories,id'];
        }
        if ($request->sub_category != "") {
            $rules = ['child_category' => 'required|exists:child_categories,id'];
        }

        $rules = [
            'product_name' => 'required',
            'category' => 'required|exists:categories,id',
            'price' => 'required',
            'tax' => 'required',
            'product_image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
//            'size'              => 'required',
//            'type'              => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
//            echo json_encode($request->description);
//            exit;
            // product image move
            if ($request->file('product_image') != "") {
                $favicon = uniqid(time()) . '.' . $request->product_image->extension();
                $request->product_image->move(public_path('assets/admin/assets/img/product_image'), $favicon);
                $favicon = "/public/assets/admin/assets/img/product_image/" . $favicon;
            } else {
                $favicon = '/public/assets/admin/assets/img/default_cate.jpeg';
            }
            // Des
//            $des = json_encode($request->addon);

            if (!empty($request->properties_check) && $request->properties_check === 'on') {
                $p_check = 1;
            } else {
                $p_check = 0;
            }

            if (!empty($request->variations_check) && $request->variations_check === 'on') {
                $v_check = 1;
            } else {
                $v_check = 0;
            }

            $data = new Products();
            $input['product_name'] = $request->product_name;
            $input['product_img'] = $favicon;
            $input['product_des'] = $request->description;
            $input['price'] = $request->price;
            $input['tax'] = $request->tax;
            $input['category'] = $request->category;
            $input['sub_category'] = $request->sub_category;
            $input['child_category'] = $request->child_category;
//            $input['size']          = $request->size;
            $input['addon'] = $request->product_promotion ? 1 : 0;
//            $input['type']          = $request->type;
            $input['has_varients'] = $v_check;
            $input['has_properties'] = $p_check;
            $save = $data->fill($input)->save();

            if (!empty($request->variations_check) && $request->variations_check === 'on') {
                if (!empty($request->variations)) {
                    foreach ($request->variations as $varKey => $varry) {
                        $varr = new ProductVarients();
                        $input2['product_id'] = $data->id;
                        $input2['varients_id'] = $varry;
                        $input2['varients_price'] = $request->variant_price[$varKey];
                        $varr->fill($input2)->save();
                    }
                }
            }

            if (!empty($request->toppings_check) && $request->toppings_check === 'on') {
                if (!empty($request->toppings)) {
                    foreach ($request->toppings as $topKey => $topp) {
                        $top = new ProductToppings();
                        $input4['product_id'] = $data->id;
                        $input4['ingredients_id'] = $topp;
                        $input4['ingredents_price'] = $request->topping_price[$topKey];
                        $top->fill($input4)->save();
                    }
                }
            }

            if (!empty($request->properties_check) && $request->properties_check === 'on') {
                if (!empty($request->properties)) {
                    foreach ($request->properties as $prr) {
                        $prrr = new ProductProperty();
                        $input3['product_id'] = $data->id;
                        $input3['properties_id'] = $prr;
                        $prrr->fill($input3)->save();
                    }
                }
            }

//            if($request->product_promotion == 1)
//            {
//                foreach($request->addon as $key => $item)
//                {
//                    $addon      = new ProductAddOn();
//                    $input1['product_id']   = $data->id;
//                    $input1['variant']      = $item;
//                    $saveAddOn = $addon->fill($input1)->save();
//                }
//            }
//            if(!empty($request->extra)) {
//                foreach($request->extra as $item)
//                {
//                    $getId                  = Extra::where(['name' => $item])->first();
//                    $extraAdd               = new ProductExtra();
//                    $input2['name']         = $item;
//                    $input2['extra_id']     = $getId->id;
//                    $input2['product_id']   = $data->id;
//                    $saveExtra =  $extraAdd->fill($input2)->save();
//                    $extras[$item] = ['full' , 'half' , 'medium' , 'extra'];
//                    $getProduct = Products::findOrFail($data->id);
//                    $getProduct->extra = json_encode($extras);
//                    $getProduct->update();
//                }
//
//            }
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => 'Product save successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => 'Errors Occurs try again later!!']);
            exit;
        }
    }

    /**
     * @return view product list
     */
    public function productList()
    {
        return view('admin.product.product_list');
    }

    /**
     * @method use for show product list help of aja
     */
    public function productAjaxList(Request $request)
    {
        if (isset($_GET['search']['value'])) {
            $search = $_GET['search']['value'];
        } else {
            $search = '';
        }
        if (isset($_GET['length'])) {
            $limit = $_GET['length'];
        } else {
            $limit = 10;
        }

        if (isset($_GET['start'])) {
            $ofset = $_GET['start'];
        } else {
            $ofset = 0;
        }

        $orderType = $_GET['order'][0]['dir'];
        $nameOrder = $_GET['columns'][$_GET['order'][0]['column']]['name'];

        $total = Products::select("products.*", "categories.cate_name",
            "sub_categories.name as subname", "child_categories.name as childname")
            ->join("categories", "products.category", "=", "categories.id")
            ->leftjoin("sub_categories", "products.sub_category", "=", "sub_categories.id")
            ->leftjoin("child_categories", "products.child_category", "=", "child_categories.id")
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('cate_name', 'like', '%' . $search . '%');
                $query->orWhere('product_name', 'like', '%' . $search . '%');
                $query->orWhere('sub_categories.name', 'like', '%' . $search . '%');
                $query->orWhere('child_categories.name', 'like', '%' . $search . '%');
            })->count();

        $products = Products::select("products.*", "categories.cate_name",
            "sub_categories.name as subname", "child_categories.name as childname")
            ->join("categories", "products.category", "=", "categories.id")
            ->leftjoin("sub_categories", "products.sub_category", "=", "sub_categories.id")
            ->leftjoin("child_categories", "products.child_category", "=", "child_categories.id")
            ->orWhere(function ($query) use ($search) {
                $query->orWhere('cate_name', 'like', '%' . $search . '%');
                $query->orWhere('product_name', 'like', '%' . $search . '%');
                $query->orWhere('sub_categories.name', 'like', '%' . $search . '%');
                $query->orWhere('child_categories.name', 'like', '%' . $search . '%');
            })
            ->offset($ofset)->limit($limit)
            ->orderBy($nameOrder, $orderType)->get();

        $i = 1 + $ofset;
        $data = [];
        foreach ($products as $cate) {
            $status = '<button class="statusVerifiedClick btn btn-sm ' . ($cate->status == 1 ? "btn-success" : "btn-danger") . '  " data-status="' . ($cate->status == 1 ? '0' : '1') . '" data-id="' . $cate->id . '">' . ($cate->status == 1 ? "Active" : "De-Active") . '</button>
                       ';
            $data[] = array(
                $i++,
                '<img class="round justify-content-center" src="' . url($cate->product_img ? $cate->product_img : 'public/assets/admin/assets/img/default_cate.jpeg') . '" style="height:30px;"><br><b>' . $cate->product_name . '<b>',
                $cate->cate_name,
                $cate->subname,
                '<b>$ ' . $cate->price . '</b>',
                $cate->tax . '%',
                $status,
                '<a href="' . url('admin/product/add-default-toppings/' . $cate->id) . '" class="btn btn-danger btn-sm product-add-default"><i class="fa fa-plus"></i></a>',
                '<a  href="' . url('admin/product/edit/' . $cate->id) . '" class="editCategory btn btn-info btn-sm " data-name="' . $cate->cate_name . '" data-img="' . $cate->cate_img . '" data-id="' . $cate->id . '"> <i class="fa fa-edit"></i></a> |
                    <a href="#" class="btn btn-danger btn-sm product-delete" data-id="' . $cate->id . '"><i class="fa fa-trash"></i></a>',

            );
        }
        $records['recordsTotal'] = $total;
        $records['recordsFiltered'] = $total;
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function add_default_toppings($id){
        $category = Category::where(['status' => 1])->get();
        $products = Products::select("products.*", "sub_categories.name as subname", "child_categories.name as childname")
            ->leftjoin("sub_categories", "products.sub_category", "=", "sub_categories.id")
            ->leftjoin("child_categories", "products.child_category", "=", "child_categories.id")
            ->where(['products.id' => $id])->first();

        $addon = ProductAddOn::where(['product_id' => $id])->get();

        $sizes = Size::where(['status' => 1])->get();
        $types = Type::where(['status' => 1])->get();
        $extras = Extra::where(['status' => 1])->get();
        $variations = Variation::where(['status' => 1])->get();
        $properties = Propertie::where(['status' => 1])->get();
        $getProductProperties = ProductProperty::select('properties_id')->where(['product_id' => $id])->get();
        $ppr = [];
        foreach ($getProductProperties as $pr) {
            $ppr[] = $pr->properties_id;
        }
        $getProductVarients = ProductVarients::select('varients_id', 'varients_price')->where(['product_id' => $id])->get();
        $vvr = [];
        $vvrP = [];
        $vvName = [];
        foreach ($getProductVarients as $vr) {
            $vari = Variation::where(['id' => $vr->varients_id])->first();
            $vvName[] = $vari->name;
            $vvr[] = $vr->varients_id;
            $vvrP[] = $vr->varients_price;
        }
        $properties_ids = [];
        foreach ($properties as $pr){
            if(in_array($pr->id, $ppr)){
                $properties_ids[] = $pr->id;
            }
        }

        $productCrurstss = ProductToppings::where('product_id', $id)->get();
        $productCrurstsIds = [];
        foreach($productCrurstss as $pi){
            $productCrurstsIds[] = $pi->ingredients_id;
        }

        $productCrursts = IndItem::whereIn('id', $productCrurstsIds)->get();

        $propertiesItems = PropertiesItems::whereIn('properties_id', $properties_ids)->get();

        $product_extra = ProductExtra::where(['product_id' => $id])->get();

        return view('admin.product.add_default_toppings', compact('productCrursts', 'category', 'vvName', 'vvrP', 'vvr', 'ppr', 'products', 'addon', 'sizes', 'types', 'extras', 'product_extra', 'variations', 'properties'));
    }

    public static function getPropertyItemsByPropertyId($property_id){
        $propertiesItems = PropertiesItems::where('properties_id', $property_id)->get();
        return $propertiesItems;
    }

    /**
     * @param Request $request
     * @method use for update product status
     */
    public function statusUpdate(Request $request)
    {
        $where = array('id' => $request->id);
        $data = array(
            'status' => $request->status,
        );

        $update = Products::where($where)->update($data);

        if ($update) {
            return response()->json(array('status' => true, 'msg' => "Successfully Updated !"));
            exit;
        } else {
            return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
            exit;
        }
    }


    /**
     * @param Request $request
     * @method use for delete product
     */
    public function productDelete(Request $request)
    {
        try {
            $where = array('id' => $request->id);
            $cate = Products::find($request->id);
            $del = Products::where($where)->delete();
            File::delete(public_path('../' . $cate->product_img));

            if ($del) {
                return response()->json(array('status' => true, 'msg' => "Successfully Deleted !!!!"));
                exit;
            } else {
                return response()->json(array('status' => false, 'msg' => "Error Occured, please try again"));
                exit;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(array('status' => false, 'msg' => 'Something went wrong !!!!'));
        }
    }

    /**
     * @param $id
     * @return view edit product form
     */
    public function edit(Request $request)
    {
        $category = Category::where(['status' => 1])->get();
        $products = Products::select("products.*", "sub_categories.name as subname", "child_categories.name as childname")
            ->leftjoin("sub_categories", "products.sub_category", "=", "sub_categories.id")
            ->leftjoin("child_categories", "products.child_category", "=", "child_categories.id")
            ->where(['products.id' => $request->id])->first();

        $addon = ProductAddOn::where(['product_id' => $request->id])->get();

        $sizes = Size::where(['status' => 1])->get();
        $types = Type::where(['status' => 1])->get();
        $extras = Extra::where(['status' => 1])->get();
        $variations = Variation::where(['status' => 1])->get();
        $properties = Propertie::where(['status' => 1])->get();
        $getProductProperties = ProductProperty::select('properties_id')->where(['product_id' => $request->id])->get();
        $ppr = [];
        foreach ($getProductProperties as $pr) {
            $ppr[] = $pr->properties_id;
        }
        $getProductVarients = ProductVarients::select('varients_id', 'varients_price')->where(['product_id' => $request->id])->get();
        $vvr = [];
        $vvrP = [];
        $vvName = [];
        foreach ($getProductVarients as $vr) {
            $vari = Variation::where(['id' => $vr->varients_id])->first();
            $vvName[] = $vari->name;
            $vvr[] = $vr->varients_id;
            $vvrP[] = $vr->varients_price;
        }

        $product_extra = ProductExtra::where(['product_id' => $request->id])->get();

        return view('admin.product.edit', compact('category', 'vvName', 'vvrP', 'vvr', 'ppr', 'products', 'addon', 'sizes', 'types', 'extras', 'product_extra', 'variations', 'properties'));
    }

    /**
     * @param Request $request
     * @method use for update product
     */
    public function update(Request $request)
    {
        $data = Products::findOrFail($request->product_id);
        $rules = [];
        if (!empty($request->properties_check) && $request->properties_check === 'on') {
            $rules = ['properties' => 'required'];
        }

        if (!empty($request->variations_check) && $request->variations_check === 'on') {
            $rules = ['variations' => 'required'];
            $rules = ['variant_price' => 'required'];
        }

        if ($request->sub_category != "") {
            if ($request->sub_category != $data->sub_category) {
                $rules = ['sub_category' => 'required|exists:sub_categories,id'];
            }
        }
        if ($request->child_category != "") {
            if ($request->child_category != $data->child_category) {
                $rules = ['child_category' => 'required|exists:child_categories,id'];
            }
        }

        if ($request->category != $data->category) {
            $rules = ['category' => 'required|exists:categories,id'];
        }

        if ($request->file('product_image') != "") {
            $rules['product_image'] = 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048';
        }

        $rules = [
            'product_name' => 'required',
            'price' => 'required',
            'tax' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {
            // product image move
            if ($request->file('product_image') != "") {
                File::delete(public_path('../' . $request->oldimage));
                $favicon = uniqid(time()) . '.' . $request->product_image->extension();
                $request->product_image->move(public_path('assets/admin/assets/img/product_image'), $favicon);
                $favicon = "/public/assets/admin/assets/img/product_image/" . $favicon;
                $input['product_img'] = $favicon;
            }

            if (!empty($request->properties_check) && $request->properties_check === 'on') {
                $p_check = 1;
            } else {
                $p_check = 0;
            }

            if (!empty($request->variations_check) && $request->variations_check === 'on') {
                $v_check = 1;
            } else {
                $v_check = 0;
            }

            $input['product_name'] = $request->product_name;
            $input['product_des'] = $request->description;
            $input['price'] = $request->price;
            $input['tax'] = $request->tax;
            $input['category'] = $request->category;
            $input['sub_category'] = $request->sub_category;
            $input['child_category'] = $request->child_category;
//            $input['size']          = $request->size;
            $input['addon'] = $request->product_promotion ? 1 : 0;
//            $input['type']          = $request->type;
            $input['has_varients'] = $v_check;
            $input['has_properties'] = $p_check;
            $save = $data->fill($input)->update();

            if (!empty($request->variations_check) && $request->variations_check === 'on') {
                if (!empty($request->variations)) {
                    ProductVarients::where(['product_id' => $request->product_id])->delete();
                    foreach ($request->variations as $varKey => $varry) {
                        $varr = new ProductVarients();
                        $input2['product_id'] = $data->id;
                        $input2['varients_id'] = $varry;
                        $input2['varients_price'] = $request->variant_price[$varKey];
                        $varr->fill($input2)->save();
                    }
                }
            }

            if (!empty($request->properties_check) && $request->properties_check === 'on') {
                if (!empty($request->properties)) {
                    ProductProperty::where(['product_id' => $request->product_id])->delete();
                    foreach ($request->properties as $prr) {
                        $prrr = new ProductProperty();
                        $input3['product_id'] = $data->id;
                        $input3['properties_id'] = $prr;
                        $prrr->fill($input3)->save();
                    }
                }
            }
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => 'Product update successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => 'Errors Occurs try again later!!']);
            exit;
        }
    }

    public function update_default(Request $request)
    {

        $rules = [
            'variations' => 'required',
            'crust' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()]);
            exit;
        } else {

            $data = Products::findOrFail($request->product_id);
            $input['default_toppings'] = json_encode($request->pi_items);
            $input['default_varients'] = $request->variations;
            $input['default_crust'] = $request->crust;
            $save = $data->fill($input)->update();
        }

        if ($save) {
            return response()->json(['status' => true, 'msg' => 'Default product update successfully']);
            exit;
        } else {
            return response()->json(['status' => false, 'msg' => 'Errors Occurs try again later!!']);
            exit;
        }
    }
}
