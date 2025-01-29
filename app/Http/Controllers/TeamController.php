<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::with('image')->simplePaginate(10);
        $page_name = 'Team';
        $breadcrumbs = [
            [
                'value' => 'Team',
                'url' => '',
            ],
        ];
        return view('dashboard.views.landing-page-setting.team.index-team', compact('teams', 'page_name', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'job_title' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50048',
                'crop_x' => 'required|integer',
                'crop_y' => 'required|integer',
                'crop_width' => 'required|integer',
                'crop_height' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            //upload image
            $imageId = null;
            if ($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                    $imageId = $this->saveUploadImage($request->crop_x, $request->crop_y, $request->crop_width, $request->crop_height, $request->file('image'), null, 'team');
                }
            }

            $team = Team::create([
                'name' => $request->name,
                'job_title' => $request->job_title,
                'landing_page_id' => 1,
                'image_id' => $imageId,
            ]);
            return redirect()->back()->with('success', 'Team created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $team = Team::find($id);
            if (!$team) {
                throw new \Exception('Team not found');
            }

            $page_name = 'Edit Team';
            $breadcrumbs = [
                [
                    'value' => 'Team',
                    'url' => 'landing-page-settings.team.index',
                ],
                [
                    'value' => 'Edit Team',
                    'url' => '',
                ],
            ];

            return view('dashboard.views.landing-page-setting.team.edit-team', compact('team', 'page_name', 'breadcrumbs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'job_title' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50048',
                'crop_x' => 'nullable|integer',
                'crop_y' => 'nullable|integer',
                'crop_width' => 'nullable|integer',
                'crop_height' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $id = decrypt($id);
            $team = Team::find($id);
            if (!$team) {
                throw new \Exception('Team not found');
            }

            //update image
            if($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                    $imageId = $this->saveUploadImage($request->crop_x, $request->crop_y, $request->crop_width, $request->crop_height, $request->file('image'), $team->image_id, 'team');
                    Team::where('id', $id)->update([
                        'image_id' => $imageId,
                    ]);
                }
            }

            Team::where('id', $id)->update([
                'name' => $request->name,
                'job_title' => $request->job_title,
            ]);

            return redirect()->route('landing-page-settings.team.index')->with('success', 'Team updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id = decrypt($id);
            $team = Team::find($id);
            if (!$team) {
                throw new \Exception('Team not found');
            }

            //delete image
            $this->deleteImage($team->image_id);

            Team::where('id', $id)->delete();

            return redirect()->back()->with('success', 'Team deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
