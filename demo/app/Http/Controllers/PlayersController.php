<?php

namespace App\Http\Controllers;
use App\Http\Requests\FormValidationRequest;
use Illuminate\Http\Request;
use App\Models\Players;

class PlayersController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    //
    public function create()
    {
        return view('create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'age' => 'required|integer|min:18',
    //         'national' => 'required|string|max:255',
    //         'position' => 'required|string|max:255',
    //         'salary' => 'required|string|max:255',
    //     ], [
    //         'required' => 'Phải nhập đầy đủ thông tin.',
    //         'integer' => 'Tuổi phải là số nguyên.',
    //         'min' => 'Tuổi phải lớn hơn hoặc bằng 18.',
    //         'max' => 'Độ dài tối đa là :max ký tự.',
    //     ]);

    //     $player = new Players();
    //     $player->Ten_cau_thu = $request->name;
    //     $player->tuoi = $request->age;
    //     $player->Quoc_tich = $request->national;
    //     $player->Vi_tri = $request->position;
    //     $player->Luong = $request->salary;
    //     $player->save();
        
    //     if ($player) {
    //         return redirect()->route('players.list')->with('success');
    //     } else {
    //         return redirect()->route('players.list')->with('error');
    //     }
    // }

    public function store(FormValidationRequest $request) 
    {
        $player = new Players();
        $player->Ten_cau_thu = $request->name;
        $player->tuoi = $request->age;
        $player->Quoc_tich = $request->national;
        $player->Vi_tri = $request->position;
        $player->Luong = $request->salary;
        $player->save();
        
        // if ($player) {
        //     return redirect()->route('players.list')->with('success');
        // } else {
        //     return redirect()->route('players.list')->with('error');
        // }
        
        if ($player) {
            return response()->json(['success' => true, 'message' => 'Player created successfully', 'player' => $player]);
        } else {
            return response()->json(['success' => false, 'message' => 'Player creation failed']);
        }
    }

    public function list()
    {
        $players = Players::all();
        // return view('demolist', compact('players'));
        return response()->json(['players' => $players]);
    }

    public function edit($id)
    {
        $player = Players::findOrFail($id);
        return view('demoedit', compact('player'));
    }

    public function update(Request $request, $id)
    {
        $player = Players::findOrFail($id);
        $player->Ten_cau_thu = $request->name;
        $player->tuoi = $request->age;
        $player->Quoc_tich = $request->national;
        $player->Vi_tri = $request->position;
        $player->Luong = $request->salary;
        $player->save();

        if ($player) {
            return redirect()->route('players.list')->with('success');
        } else {
            return redirect()->route('players.list')->with('error');
        }
    }

    public function delete($id)
    {
        $player = Players::findOrFail($id);
        $player->delete();
        return redirect()->route('players.list')->with('success');
    }
}
