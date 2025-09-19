<div class="flex items-center space-x-2 max-w-[768px] mx-auto justify-end mt-[-0px] mb-5 opacity-30 hover:opacity-100">
        <span>View: </span>
        <!-- List view button -->
        <a <?= $view === 'grid' ? 'href="home.php?view=list"' : '' ?> class="inline-flex items-center gap-x-2 py-2 px-4 text-sm font-medium rounded-lg border border-gray-600 text-gray-200 outline-none <?= $view === 'list' ? 'bg-blue-700' : 'hover:bg-gray-700 active:opacity-70 bg-gray-800' ?>" <?= $view === 'list' ? 'disabled' : '' ?>>
            <i class="fa-solid fa-list"></i>
            List
        </a>

        <!-- Grid view button -->
        <a <?= $view === 'list' ? 'href="home.php?view=grid"' : '' ?> class="inline-flex items-center gap-x-2 py-2 px-4 text-sm font-medium rounded-lg border border-gray-600 text-gray-200 outline-none <?= $view === 'grid' ? 'bg-blue-700' : 'hover:bg-gray-700 active:opacity-70 bg-gray-800' ?>" <?= $view === 'grid' ? 'disabled' : '' ?>>
            <i class="fa-solid fa-th"></i>
            Grid
        </a>
    </div>