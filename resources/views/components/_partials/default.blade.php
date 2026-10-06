<!DOCTYPE html>
<html lang="en">

@include('components._partials.header')

<body class="g-sidenav-show  bg-gray-200">

	@include('components._partials.sidebar')

	<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

		@include('components._partials.navbar')

		<div class="container-fluid">

			@yield('content')

			@include('components._partials.footer')

		</div>

	</main>

	@include('components._partials.scripts')

</body>

</html>