<?php


	class SearchController extends CustomControllerAction
	{
		public function preDispatch()
		{
			parent::preDispatch();	
			$_SESSION['categoryType'] = 'product';
			$this->breadcrumbs->addStep('search');
			
		}
		
		public function indexAction()
		{
			$request= $this->getRequest();
			
			$q = $request->getQuery('q');
			
			
			
			$q = DatabaseObject_StaticUtility::cleanHtml($q);
			
			
			
			$search = array(
				'performed' => false,
				
				'total'		=> 0,
				'start'		=> 0,
				'finish'	=> 0,
				'page' 		=> (int) $request->getQuery('p'),
				'pages'		=> 1,
				'results'	=> array()
			);
			
			/*try{
				if(strlen($q) == 0)
				{
					throw new Exception('No search term specified');
				}
				
				//echo "here at search 1 <br/>";
				
				
				$path = DatabaseObject_Product::getIndexFullpath();
				
				//echo "path: ".$path;
				
				//$index = new Zend_Search_Lucene($path);
				$index = Zend_Search_Lucene::open($path);
				
				//echo "here at search2<br/>";
				$hits = $index->find($q);
				
				
				//echo "here at search3<br/>";
				
				
				if(count($hits)>0)
				{
					$search['perfomed']=true;
					$search['total'] = count($hits);
					$search['pages'] = ceil($search['total']/$search['limit']);
					$search['page'] = max(1, min($search['pages'], $search['page']));
					$offset = ($search['page']-1) * $search['limit'];
					
					$search['start'] = $offset +1;
					$search['finish'] = min($search['total'], $search['start']+$search['limit']-1);
					
					$hits = array_slice($hits, $offset, $search['limit']);
					
	
					$user_ids = array();
					foreach($hits as $hit)
					{
						$user_ids[] = (int) $hit->product_id;
					}
					
					
					//echo "here at search<br/>";
					
					$options = array('status'=>'L',
									 'product_id' => $user_ids);
					
					
					$users = DatabaseObject_Product::GetObjects($this->db, $options); 
					
					foreach($user_ids as $user_id)
					{
						if(array_key_exists($user_id, $users))
						{
							$search['results'][$user_id] = $users[$user_id];
						}
					}
					
									$this->view->users =$users;

				}
				
				//determine which users's were retrieved
				/*
				$user_ids = array();
				
				foreach($users as $user)
				{
					$user_ids[$user->userID] = $user->userID;
				}
				if(count($user_ids)>0)
				{
					$options = array('status'=>'L',
								 'userID' => $user_ids);
				
				
					$users = DatabaseObject_User::GetObjects($this->db, $options); 
					
				}
				else
				{
					$users=array();
				}
				
				*/
				
				
				
			/*}
			catch(Exception $ex)
			{
				$this->view->q = $q;
				$this->view->search = $search;
				
				echo "it can not be opeend";
				//no search performed or an error occurred
			}
			
			if($search['performed'])
			{
				$this->breadcrumbs->addStep('Search Results for '.$q);
			}
			else
			{
				$this->breadcrumbs->addStep('Search');
			}
			
			$this->view->q = $q;
				$this->view->search = $search;*/
			
			$options= array(
							
							'limit'=>1,
							'status' => 'L',
							'search'  => $q);
		
			$_SESSION['categoryType'] = 'product';
			

			$users = new DatabaseObject_Product($this->db);

			$objects = $users->GetObjects($this->db, $options); 
			
			$this->view->posts = $objects;		
			$this->breadcrumbs->addStep($q);	
		
		}
		
		public function suggestionAction()
		{
			$q = trim($this->getRequest()->getPost('q'));
			
			$q = DatabaseObject_StaticUtility::cleanHtml($q);
			
			$suggestions = DatabaseObject_Product::getUserSuggestions($this->db, $q, 15);
			
			$this->sendJson($suggestions);
		}

		
		public function googleAction()
		{
			
			
		}
			
			
	
	}
	
?>