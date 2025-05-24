<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class View extends Component
{
    public function render()
    {
        $menus = Menu::all();
        return view('livewire.menu.view', compact('menus'));
    }

    public function delete($id)
    {
        $menu = Menu::find($id);
        Storage::disk('public')->delete($menu->image);
        $menu->delete();
        $this->dispatch('menu-deleted');
    }

    public function edit($id)
    {
        return redirect()->route('menu.edit', ['id' => $id]);
    }
}
