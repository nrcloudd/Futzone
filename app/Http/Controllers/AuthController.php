<?php
namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        //get posts
        $members = User::latest()->paginate(5);

        //return collection of posts as a resource
        return new UserResource(true, 'List Data Posts', $members);
    }
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
        
    }


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable',
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        //upload image
        // $image = $request->file('image');
        // $image->storeAs('public/posts', $image->hashName());

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
    public function show()
    {
        $user = User::all();
        //return single post as a resource
        return new UserResource(true, 'Data Post Ditemukan!', $user);
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function sewa(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'id_member' => 'required',
            'id_lapangan' => 'required',
            'jam' => 'required',
            'tanggal' => 'required',
            'total_bayar' => 'required',
            'bukti_bayar' => 'required',
            //'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        //$image = $request->file('image');
        //$image->storeAs('public/posts', $image->hashName());

        //create post
        $transaksi = Transaksi::create([
            'id_member' => $request->id_member,
            'id_lapangan' => $request->id_lapangan,
            'jam' => $request->jam,
            'tanggal' => $request->tanggal,
            'total_bayar' => $request->total_bayar,
            'bukti_bayar' => $request->bukti_bayar,

            //'image'     => $image->hashName(),
        ]);

        //return response
        return new LapanganResource(true, 'Data Post Berhasil Ditambahkan!', $transaksi);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('password')) {
            $user->password = $request->input('password');
        }

        if ($request->has('phone')) {
            $user->phone = $request->input('phone');
        }

        $user->save();

        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh($forceForever = false, $resetClaims = false): string
{
    return $this->requireToken()->refresh($forceForever, $resetClaims);
}
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
{
    $ttl = 60; // Set the TTL value in minutes

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => $ttl * 60,
        'user' => auth()->user()
    ]);
}
}