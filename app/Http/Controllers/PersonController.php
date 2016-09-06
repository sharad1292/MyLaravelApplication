<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Person;
use Illuminate\Http\Request;

class PersonController extends Controller {
      public function __construct()
  {   
    $this->middleware('auth', ["only" => ["create", "edit"]]);
  } 


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index(Request $request)
    {
        $search = $request->input("search");

        if ($search != '')
        {
            $people = Person::where('first', 'LIKE', '%'. $search .'%')->
                orWhere('last', 'LIKE', '%'. $search .'%');
            $people = $people->paginate(10);
        }
        else
        {
            $people = Person::orderBy('id', 'desc')->paginate(10);
        }

        return view('people.index', compact('people'));
    }


	

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('people.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$person = new Person();

		$person->first = $request->input("first");
        $person->last = $request->input("last");
        $person->phone = $request->input("phone");
        $person->email = $request->input("email");
		$person->save();

		return redirect()->route('people.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$person = Person::findOrFail($id);

		return view('people.show', compact('person'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$person = Person::findOrFail($id);

		return view('people.edit', compact('person'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$person = Person::findOrFail($id);

		$person->first = $request->input("first");
        $person->last = $request->input("last");
        $person->phone = $request->input("phone");
        $person->email = $request->input("email");

		$person->save();

		return redirect()->route('people.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$person = Person::findOrFail($id);
		$person->delete();

		return redirect()->route('people.index')->with('message', 'Item deleted successfully.');
	}
   
    
   
}
